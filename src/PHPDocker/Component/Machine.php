<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Machine extends Component
{
    const STATE_RUNNING = 'Running';
    const STATE_PAUSED = 'Paused';
    const STATE_SAVED = 'Saved';
    const STATE_STOPPED = 'Stopped';
    const STATE_STOPPING = 'Stopping';
    const STATE_STARTING = 'Starting';
    const STATE_ERROR = 'Error';

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
        parent::__construct($binPath ?: 'docker-machine', $envVars, $logger, $outputHandler);
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
        // for some odd reason, output is reversed, eg, first ip is of last machine arg
        $output = array_reverse($output);

        return $machineNames === null
            ? (isset($output[0]) ? $output[0] : '')
            : array_combine($machineNames, $output);
    }

    /**
     * Returns URL of default machine (if $name is null), otherwise URL of the specified machine.
     *
     * @param null|string $machineName name of desired machine or `null` for the default machine
     *
     * @return string URL of the requested machine
     */
    public function getURL($machineName = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('url');

        if ($machineName !== null) {
            $builder->add($machineName);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $output = $process->mustRun($this->outputHandler)->getOutput();
        $output = str_replace(["\r\n", "\r", "\0"], "\n", $output);
        $output = array_filter(array_map('trim', explode("\n", $output)));

        if (count($output) !== 1) {
            throw new \RuntimeException('Expected one line in output, but got ' . count($output) . ' instead.');
        }

        return array_pop($output);
    }

    /**
     * Returns status of default machine (if $name is null), otherwise status of the specified machine.
     *
     * @param null|string $machineName name of desired machine or `null` for the default machine
     *
     * @return string Status of the requested machine (see self::STATE_* constants)
     */
    public function getStatus($machineName = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('status');

        if ($machineName !== null) {
            $builder->add($machineName);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $output = $process->mustRun($this->outputHandler)->getOutput();
        $output = str_replace(["\r\n", "\r", "\0"], "\n", $output);
        $output = array_filter(array_map('trim', explode("\n", $output)));

        if (count($output) !== 1) {
            throw new \RuntimeException('Expected one line in output, but got ' . count($output) . ' instead.');
        }

        return array_pop($output);
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

    /**
     * Removes the specified machine.
     *
     * @param string[] $machineNames names of machines to remove
     * @param bool $forcedRemoval If true, machine config is removed even if machine cannot be removed
     *
     * @return $this current instance, for method chaining
     */
    public function remove($machineNames = [], $forcedRemoval = false)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('rm');

        $builder->add('-y'); // do not ask for confirmation

        if ($forcedRemoval) {
            $builder->add('--force');
        }

        foreach ((array) $machineNames as $name) {
            $builder->add($name);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $process->mustRun($this->outputHandler);

        return $this;
    }

    /**
     * Restarts the specified machines.
     *
     * @param null|string[] $machineNames names of machines to restart or the default one if `null`
     *
     * @return $this current instance, for method chaining
     */
    public function restart($machineNames = null)
    {
        $builder = $this->getProcessBuilder();
        $builder->add('restart');

        foreach ((array) $machineNames as $name) {
            $builder->add($name);
        }

        $process = $builder->getProcess();

        $this->logger->debug('RUN ' . $process->getCommandLine());

        $process->mustRun($this->outputHandler);

        return $this;
    }
}
