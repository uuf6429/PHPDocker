<?php

namespace PHPDocker\Component;

use PHPDocker\Container;
use Psr\Log\LoggerInterface;

class Docker extends Component
{
    /**
     * Publish all exported ports on host, randomly.
     */
    const ALL_PORTS = '--publish-all=true';

    /**
     * @var null|string
     */
    private $dockerFile;

    /**
     * @param null|string $binPath
     * @param null|array $envVars
     * @param null|LoggerInterface $logger
     * @param callable|null $outputHandler
     */
    public function __construct(
        $binPath = null,
        array $envVars = null,
        LoggerInterface $logger = null,
        callable $outputHandler = null
    ) {
        parent::__construct($binPath ?: 'docker', $envVars, $logger, $outputHandler);
    }

    /**
     * @param string $dockerFile Full file name to a '.dockerfile'.
     *
     * @return self new instance using the specified docker file
     */
    public function withFile($dockerFile)
    {
        $clone = clone $this;

        return $clone->setDockerFile($dockerFile);
    }

    /**
     * Creates a new container from an image and (optionally) runs a command in it.
     *
     * @param string $image name of docker image
     * @param null|string $containerName name of the container (so you can find() it later on)
     * @param array $containerCmd Array of command (first item) and arguments (every other item) to execute in container
     * @param bool $background True to run container in the background.
     *                          Important! If you want container to keep running after your code ends, this must be true.
     *                          However, if set to true you won't be able to capture execution output directly.
     * @param array $envVars a list of key=>value pairs of environments to be used inside container
     * @param array|string $portMap array with string keys - a list of key-value pairs for exposing ports (key is host, value is container) eg; ['3306' => '3306']
     *                          array with integer keys - a list of port map specification strings (see docker documentation for specification) eg; ['3306:3306']
     *                          self::ALL_PORTS - exposes all exported ports (--publish-all=true) randomly
     *
     * @return $this
     *
     * @todo Handle more options and switches
     */
    public function run($image, $containerName = null, $containerCmd = [], $background = false, $envVars = [], $portMap = [])
    {
        $builder = $this->getProcessBuilder();

        $builder->add('run');

        if ($containerName) {
            $builder->add('--name')->add($containerName);
        }

        if ($background) {
            $builder->add('-d');
        }

        array_walk($envVars, function ($value, $name) use ($builder) {
            $builder->add('-e')->add("$name=$value");
        });

        if (is_string($portMap)) {
            $builder->add($portMap);
        } else {
            array_walk($portMap, function ($value, $key) use ($builder) {
                if (is_integer($key)) {
                    $builder->add('-p')->add("$value");
                } else {
                    $builder->add('-p')->add("$key=$value");
                }
            });
        }

        $builder->add($image);

        if ($containerCmd) {
            array_walk($containerCmd, function ($value) use ($builder) {
                $builder->add($value);
            });
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $process->mustRun($this->outputHandler);

        return $this;
    }

    public function attach()
    {
        // TODO
    }

    public function commit()
    {
        // TODO
    }

    /**
     * @param string $containerName name of the target container
     * @param string $sourcePath source file or directory to copy
     * @param string $targetPath destination where to copy to
     *
     * @return $this current instance, for method chaining
     */
    public function copy($containerName, $sourcePath, $targetPath)
    {
        $process = $this->getProcessBuilder()
            ->add('cp')->add($sourcePath)->add("$containerName:$targetPath")
            ->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $process->run($this->outputHandler);

        return $this;
    }

    public function diff()
    {
        // TODO
    }

    public function exec()
    {
        // TODO
    }

    public function export()
    {
        // TODO
    }

    public function kill()
    {
        // TODO
    }

    public function logs()
    {
        // TODO
    }

    public function pause()
    {
        // TODO
    }

    public function port()
    {
        // TODO
    }

    public function rename()
    {
        // TODO
    }

    public function restart()
    {
        // TODO
    }

    /**
     * Removes one or more containers given names.
     *
     * @param string|string[] $containerNames either the container name as a string or a list of container names
     * @param bool $forceRemove if true, the container will be removed forcefully, even if it is running
     * @param bool $removeVolumes if trues, also remove volumes associated to container
     *
     * @return $this
     *
     * @todo Handle --link as well
     */
    public function remove($containerNames, $forceRemove = false, $removeVolumes = false)
    {
        $builder = $this->getProcessBuilder();

        $builder->add('rm');

        if ($forceRemove) {
            $builder->add('--force');
        }

        if ($removeVolumes) {
            $builder->add('--volumes');
        }

        if (is_string($containerNames)) {
            $containerNames = [$containerNames];
        }

        foreach ($containerNames as $containerName) {
            $builder->add($containerName);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $process->mustRun($this->outputHandler);

        return $this;
    }

    public function resume()
    {
        // TODO
    }

    public function start()
    {
        // TODO
    }

    public function stop()
    {
        // TODO
    }

    public function top()
    {
        // TODO
    }

    public function update()
    {
        // TODO
    }

    public function wait()
    {
        // TODO
    }

    /**
     * Returns an object representing a container given the container name.
     * Note that the container might not exist at this or any point, so you should call exists().
     *
     * @param string $containerName
     *
     * @return Container
     */
    public function find($containerName)
    {
        return new Container($containerName, $this);
    }

    /**
     * @param string $dockerFile Full file name to a '.dockerfile'.
     *
     * @return $this current instance, for method chaining
     */
    protected function setDockerFile($dockerFile)
    {
        $this->dockerFile = $dockerFile;

        return $this;
    }
}
