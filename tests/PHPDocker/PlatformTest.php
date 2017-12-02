<?php

namespace PHPDocker\Tests;

use PHPDocker\Manager;

class PlatformTest extends \PHPUnit_Framework_TestCase
{
    public function testDockerAvailability()
    {
        if (getenv('RUN_DOCKER_NATIVE_TESTS')) {
            $this->assertFalse((new Manager())->isDockerToolbox());
            $this->assertTrue((new Manager())->isInstalled());
        } elseif (getenv('RUN_DOCKER_TOOLBOX_TESTS')) {
            $this->assertTrue((new Manager())->isDockerToolbox());
            $this->assertTrue((new Manager())->isInstalled());
        } else {
            $this->markAsRisky();
            $this->markTestSkipped(
                'Both RUN_DOCKER_NATIVE_TESTS and RUN_DOCKER_TOOLBOX_TESTS environment '
                . 'variables were not set, so some platform-specific tests may fail.'
            );
        }
    }
}
