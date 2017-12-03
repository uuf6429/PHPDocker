<?php

namespace PHPDocker\Tests;

trait PlatformSpecificTrait
{
    protected static $ENV_DOCKER_NATIVE = 'RUN_DOCKER_NATIVE_TESTS';
    protected static $ENV_DOCKER_TOOLBOX = 'RUN_DOCKER_TOOLBOX_TESTS';

    /** @return bool */
    protected function isDockerNative()
    {
        return (bool) getenv(self::$ENV_DOCKER_NATIVE);
    }

    /** @return bool */
    protected function isDockerToolbox()
    {
        return (bool) getenv(self::$ENV_DOCKER_TOOLBOX);
    }

    protected function skipIfUnknownDocker()
    {
        if (!$this->isDockerNative() && !$this->isDockerToolbox()) {
            $this->markTestSkipped(sprintf(
                'Test requires either %s or %s environment variable to be set.',
                self::$ENV_DOCKER_NATIVE,
                self::$ENV_DOCKER_TOOLBOX
            ));
        }
    }

    protected function skipIfNotDockerNative()
    {
        if (!$this->isDockerNative()) {
            $this->markTestSkipped(sprintf(
                'Test requires %s environment variable to be set.',
                self::$ENV_DOCKER_NATIVE
            ));
        }
    }

    protected function skipIfNotDockerToolbox()
    {
        if (!$this->isDockerToolbox()) {
            $this->markTestSkipped(sprintf(
                'Test requires %s environment variable to be set.',
                self::$ENV_DOCKER_TOOLBOX
            ));
        }
    }
}
