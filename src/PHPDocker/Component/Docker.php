<?php

namespace PHPDocker\Component;

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
     * @param null|LoggerInterface $logger
     * @param callable|null $outputHandler
     */
    public function __construct($binPath = null, LoggerInterface $logger = null, callable $outputHandler = null)
    {
        parent::__construct($binPath ?: 'docker', $logger, $outputHandler);
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
    public function run($image, $containerCmd = [], $background = false, $envVars = [], $portMap = [])
    {
        $builder = $this->getProcessBuilder();

        $builder->add('run');

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

        $process->mustRun($this->outputHandler); // TODO handle output

        return $this;
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
