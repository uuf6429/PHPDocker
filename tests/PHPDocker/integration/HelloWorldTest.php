<?php

namespace PHPDocker\Tests;

use PHPDocker\Manager;

class HelloWorldTest extends \PHPUnit_Framework_TestCase
{
    use PlatformSpecificTrait;

    public function testDockerHelloWorldWithOutput()
    {
        $this->skipIfUnknownDocker();

        $this->expectOutputRegex('/Hello from Docker!/');

        $manager = new Manager();
        $manager->docker
            ->withOutputHandler(function ($type, $text) {
                echo "$type: $text\n";
            })
            ->run('hello-world');
    }

    public function testDockerAmbitiousTestWithOutput()
    {
        $this->skipIfUnknownDocker();

        $this->expectOutputRegex('/GNU bash, version /');

        $manager = new Manager();
        $manager->docker
            ->withOutputHandler(function ($type, $text) {
                echo "$type: $text\n";
            })
            ->run('ubuntu', ['bash', '--version']);
    }
}
