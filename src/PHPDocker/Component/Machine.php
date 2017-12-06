<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Machine extends Component
{
    /**
     * @param null|string $binPath
     * @param null|LoggerInterface $logger
     * @param callable|null $outputHandler
     */
    public function __construct($binPath = null, LoggerInterface $logger = null, callable $outputHandler = null)
    {
        parent::__construct($binPath ?: 'docker-machine', $logger, $outputHandler);
    }

    /**
     * Finds the currently active machine.
     *
     * @param null|int $timeout timeout in seconds
     *
     * @return string name of active machine
     */
    public function getActive($timeout = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('active');

        if ($timeout !== null) {
            $builder->add('--timeout')->add($timeout);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        return trim($process->mustRun($this->outputHandler)->getOutput());
    }

    /**
     * Returns IP of default machine (if $names is null), otherwise IPs of the specified machines.
     *
     * @param null|string[] $machineNames names of desired machines or `null` for the default machine
     *
     * @return string|string[] IP of default machine or an array of IPs for the specified machines
     */
    public function getIPs($machineNames = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('ip');

        foreach ((array) $machineNames as $name) {
            $builder->add($name);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $output = $process->mustRun($this->outputHandler)->getOutput();
        $output = str_replace(["\r\n", "\r", "\0"], "\n", $output);
        $output = array_filter(array_map('trim', explode("\n", $output)));

        return $machineNames === null
            ? (isset($output[0]) ? $output[0] : '')
            : array_combine($machineNames, $output);
    }

    /**
     * Returns array of environment variables that must be set for docker to use a specific machine.
     *
     * @param null|string $machineName name of desired machine or `null` for the default machine
     *
     * @return array array of environment variables as key=>value pairs
     */
    public function getEnvVars($machineName = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('env');

        // force cmd-style output for parsing
        $builder->add('--shell')->add('cmd');

        if ($machineName !== null) {
            $builder->add($machineName);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $output = $process->mustRun($this->outputHandler)->getOutput();

        if (!preg_match_all('/^SET (\\w+)=(.+)$/m', $output, $matches)) {
            throw new \RuntimeException('Could not parse environment variables.');
        }

        return array_combine($matches[1], $matches[2]);
    }
}
