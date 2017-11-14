<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Machine extends Component
{
    /**
     * @param null|string $binPath
     * @param null|LoggerInterface $logger
     */
    public function __construct($binPath = null, LoggerInterface $logger = null)
    {
        parent::__construct($binPath ?: 'docker-machine', $logger);
    }

    /**
     * Returns name of active machine.
     *
     * @param null|int Timeout in seconds.
     *
     * @return string
     */
    public function getActive($timeout = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('active');

        if ($timeout !== null) {
            $builder->add('--timeout')->add($timeout);
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        return trim($process->mustRun()->getOutput());
    }

    /**
     * Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.
     *
     * @param null|string[] $machineNames
     *
     * @return string|string[] IP of default machine or an array of IPs for the specified machines.
     */
    public function getIPs($machineNames = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('ip');

        foreach ((array) $machineNames as $name) {
            $builder->add($name);
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        $output = $process->mustRun()->getOutput();
        $output = str_replace(["\r\n", "\r", "\0"], "\n", $output);
        $output = array_filter(array_map('trim', explode("\n", $output)));

        return $machineNames === null
            ? (isset($output[0]) ? $output[0] : '')
            : array_combine($machineNames, $output);
    }
}
