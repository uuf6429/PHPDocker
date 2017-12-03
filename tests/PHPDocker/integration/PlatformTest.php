<?php

namespace PHPDocker\Tests;

use PHPDocker\Manager;

class PlatformTest extends \PHPUnit_Framework_TestCase
{
    use PlatformSpecificTrait;

    public function testDockerAvailability()
    {
        $this->skipIfUnknownDocker();

        if ($this->isDockerNative()) {
            $this->assertFalse((new Manager())->isDockerToolbox());
            $this->assertTrue((new Manager())->isInstalled());
        }

        if ($this->isDockerToolbox()) {
            $this->assertTrue((new Manager())->isDockerToolbox());
            $this->assertTrue((new Manager())->isInstalled());
        }
    }
}
