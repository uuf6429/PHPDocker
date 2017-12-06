<?php

namespace PHPDocker\Tests;

use PHPDocker\Manager;
use Symfony\Component\Debug\BufferingLogger;

class MysqlTest extends \PHPUnit_Framework_TestCase
{
    use PlatformSpecificTrait;

    /**
     * Runs the mysql image, waits for connection, runs query and exits.
     *
     * @todo Make use of `waitForSuccess()` feature instead of rolling out one from scratch
     */
    public function testDockerHelloWorldWithOutput()
    {
        $this->skipIfUnknownDocker();

        $logger = new BufferingLogger();
        $manager = new Manager($logger);

        $host = $manager->machine->getIPs();
        $user = 'user';
        $pass = 'pass';

        $manager->docker->run('mysql:5.7', [], true, [
            //'MYSQL_ROOT_PASSWORD' => uniqid(),
            'MYSQL_RANDOM_ROOT_PASSWORD' => 'yes',
            'MYSQL_USER' => $user,
            'MYSQL_PASSWORD' => $pass,
        ], ['3306:3306']);

        $start = time();
        $logger->info('Waiting for db...');
        while (!$this->checkConnection($host, $user, $pass)) {
            if (time() - 60 > $start) { // time out in 60s
                $this->fail(
                    'Gave up trying to connect to db. Full output: '
                    . PHP_EOL . implode(PHP_EOL, array_column($logger->cleanLogs(), 1))
                );
            }

            $logger->info('Still waiting...');

            sleep(1);
        }

        // TODO kill mysql container
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $pass
     *
     * @return bool
     */
    private function checkConnection($host, $user, $pass)
    {
        try {
            if (!($conn = mysqli_connect($host, $user, $pass))) {
                return false;
            }
            try {
                return (bool) mysqli_query($conn, 'SELECT 1');
            } finally {
                mysqli_close($conn);
            }
        } catch (\Exception $ex) {
            return false;
        }
    }
}
