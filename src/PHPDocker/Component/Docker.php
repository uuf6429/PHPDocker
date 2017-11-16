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
     * @param string $dockerFile
     *
     * @return $this
     */
    public function withFile($dockerFile)
    {
        $clone = clone $this;

        return $clone->setDockerFile($dockerFile);
    }

    /**
     * @param string $dockerFile
     *
     * @return $this
     */
    public function setDockerFile($dockerFile)
    {
        $this->dockerFile = $dockerFile;

        return $this;
    }

    /**
     * @param string $containerName
     * @param string $sourcePath
     * @param string $targetPath
     *
     * @return $this
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
