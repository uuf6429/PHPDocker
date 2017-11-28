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
     */
    public function __construct($binPath = null, LoggerInterface $logger = null)
    {
        parent::__construct($binPath ?: 'docker', $logger);
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
     * @param string $dockerFile Full file name to a '.dockerfile'.
     *
     * @return $this current instance, for method chaining
     */
    public function setDockerFile($dockerFile)
    {
        $this->dockerFile = $dockerFile;

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
}
