<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Docker extends Component
{
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
     * @param array|string $portMap A list of ports to expose to the host (key) from container (value).
     *                          If an asterisk is passed in place of an array, all exportable ports are exposed (--publish-all=true).
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

        if ($portMap === '*') {
            $builder->add('--publish-all=true');
        } else {
            array_walk($portMap, function ($value) use ($builder) {
                $builder->add('-p')->add($value);
            });
        }

        $builder->add($image);

        if ($containerCmd) {
            array_walk($containerCmd, function ($value) use ($builder) {
                $builder->add($value);
            });
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

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

        $this->logger->debug('> ' . $process->getCommandLine());

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
