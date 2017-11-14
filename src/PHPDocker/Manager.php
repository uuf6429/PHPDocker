<?php

namespace PHPDocker;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * @property Component\Docker  $docker
 * @property Component\Compose $compose
 * @property Component\Machine $machine
 */
class Manager
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Component\Component[]
     */
    protected $components = [
        'docker' => null,
        'compose' => null,
        'machine' => null,
    ];

    /**
     * @param null|LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ? $logger : new NullLogger();
    }

    /**
     * Magic getter + class PHPDoc is the only way we can implement readonly properties in PHP.
     *
     * @param string $name
     *
     * @return null|Component\Component
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->components)) {
            trigger_error(sprintf('Notice: Undefined property: %s::$%s', __CLASS__, $name));

            return null;
        }

        return $this->components[$name] ?: ($this->components[$name] = $this->buildComponent($name));
    }

    /**
     * @param string $key
     *
     * @return Component\Component
     */
    protected function buildComponent($key)
    {
        switch ($key) {
            case 'docker':
                return new Component\Docker(null, $this->logger);
            case 'compose':
                return new Component\Compose(null, $this->logger);
            case 'machine':
                return new Component\Machine(null, $this->logger);
            default:
                throw new \LogicException("Cannot build unknown component \"$key\".");
        }
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        foreach (array_keys($this->components) as $name) {
            if (!$this->$name->isInstalled()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDockerToolbox()
    {
        return (bool) getenv('DOCKER_TOOLBOX_INSTALL_PATH');
    }
}
