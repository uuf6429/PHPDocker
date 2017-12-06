<?php

namespace PHPDocker\Tests;

use PHPDocker\Manager;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    use PlatformSpecificTrait;

    /**
     * Runs the hello-world image and checks output.
     */
    public function testDockerHelloWorldWithOutput()
    {
        $this->skipIfUnknownDocker();

        $this->expectOutputRegex('/Hello from Docker!/');

        $manager = new Manager();
        $manager->docker
            ->withOutputHandler(function ($type, $text) {
                echo "$type: $text\n";
            })
            ->run('hello-world', 'test-container')
            ->remove('test-container', true, true);
    }

    /**
     * Runs the ubuntu image, queries bash version and checks output.
     */
    public function testDockerAmbitiousTestWithOutput()
    {
        $this->skipIfUnknownDocker();

        $this->expectOutputRegex('/GNU bash, version /');

        $manager = new Manager();
        $manager->docker
            ->withOutputHandler(function ($type, $text) {
                echo "$type: $text\n";
            })
            ->run('ubuntu', 'test-container', ['bash', '--version'])
            ->remove('test-container', true, true);
    }
}
