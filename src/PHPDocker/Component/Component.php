<?php

namespace PHPDocker\Component;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;

abstract class Component
{
    /**
     * @var string
     */
    private $bin;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param null|string $binPath
     * @param null|LoggerInterface $logger
     */
    public function __construct($binPath = null, LoggerInterface $logger = null)
    {
        if (!$binPath) {
            throw new \InvalidArgumentException('Argument $binPath must not be empty.');
        }

        $this->bin = $binPath;
        $this->logger = $logger ? $logger : new NullLogger();
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        $process = $this->getProcessBuilder()->add('-v')->getProcess();
        $process->mustRun();

        if (preg_match('/version ([\\.\\w-]+), build/', $process->getOutput(), $matches)) {
            return $matches[1];
        } else {
            throw new \RuntimeException('Could not determine version.');
        }
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        try {
            return (bool)$this->getVersion();
        } catch (ProcessFailedException $ex) {
            return false;
        }
    }

    /**
     * @return ProcessBuilder
     */
    protected function getProcessBuilder()
    {
        return ProcessBuilder::create([$this->bin]);
    }
}
