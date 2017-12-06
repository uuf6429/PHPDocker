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
     * @var null|callable
     */
    protected $outputHandler;

    /**
     * @var null|array
     */
    protected $env;

    /**
     * @var Component\Component[]
     */
    protected $components = [
        'docker' => null,
        'compose' => null,
        'machine' => null,
    ];

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param callable|null $outputHandler
     * @param bool $autoSetupEnvironment when true, Docker environment variables are set up automatically if missing
     */
    public function __construct(LoggerInterface $logger = null, callable $outputHandler = null, $autoSetupEnvironment = true)
    {
        $this->logger = $logger ?: new NullLogger();
        $this->outputHandler = $outputHandler;

        if ($autoSetupEnvironment && !$this->isDockerEnvSet()) {
            $this->env = $this->machine->getEnvVars();
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
     * Returns true if Docker Toolbox is installed (by checking environment variables).
     * Note that in some messed up installation scenarios, this might return a false positive.
     *
     * @return bool
     */
    public function isDockerToolbox()
    {
        return (bool) getenv('DOCKER_TOOLBOX_INSTALL_PATH');
    }

    /**
     * Checks if Docker environment variables are set, in particular DOCKER_HOST.
     *
     * @return bool
     */
    public function isDockerEnvSet()
    {
        return (bool) getenv('DOCKER_HOST');
    }

    /**
     * Magic getter + class PHPDoc is the only way we can implement readonly properties in PHP.
     *
     * @param string $name
     *
     * @return null|Component\Component
     *
     * @internal
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
                return new Component\Docker(null, $this->env, $this->logger, $this->outputHandler);
            case 'compose':
                return new Component\Compose(null, $this->env, $this->logger, $this->outputHandler);
            case 'machine':
                return new Component\Machine(null, $this->env, $this->logger, $this->outputHandler);
            default:
                throw new \LogicException("Cannot build unknown component \"$key\".");
        }
    }
}
