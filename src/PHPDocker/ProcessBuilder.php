<?php

namespace PHPDocker;

use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Process\Process;

/**
 * @internal symfony's ProcessBuilder has been deprecated and since we make heavy use
 *           of the process building concept, we ended up with our own implementation
 */
class ProcessBuilder
{
    const OUT = Process::OUT;
    const ERR = Process::ERR;

    private $exec;
    private $args;
    private $cwd;
    private $env = [];
    private $inheritEnv = true;

    /**
     * @param string $executable
     * @param string[] $arguments
     */
    public function __construct($executable, array $arguments = [])
    {
        $this->exec = $executable;
        $this->args = $arguments;
    }

    /**
     * @param string $executable
     * @param string[] $arguments
     *
     * @return static
     */
    public static function create($executable, array $arguments = [])
    {
        return new static($executable, $arguments);
    }

    /**
     * @param string $argument
     *
     * @return $this
     */
    public function add($argument)
    {
        $this->args[] = $argument;

        return $this;
    }

    /**
     * @param string[] $arguments
     *
     * @return $this
     */
    public function setArgs(array $arguments)
    {
        $this->args = $arguments;

        return $this;
    }

    /**
     * @param null|string $cwd
     *
     * @return $this
     */
    public function setWorkingDirectory($cwd)
    {
        $this->cwd = $cwd;

        return $this;
    }

    /**
     * @param bool $inheritEnv
     *
     * @return $this
     */
    public function inheritEnvVars($inheritEnv = true)
    {
        $this->inheritEnv = $inheritEnv;

        return $this;
    }

    /**
     * @param string $name
     * @param null|string $value
     *
     * @return $this
     */
    public function setEnvVar($name, $value)
    {
        $this->env[$name] = $value;

        return $this;
    }

    /**
     * @param array $variables
     *
     * @return $this
     */
    public function addEnvVars(array $variables)
    {
        $this->env = array_replace($this->env, $variables);

        return $this;
    }

    /**
     * @throws LogicException
     *
     * @return Process
     */
    public function getProcess()
    {
        if (!$this->exec) {
            throw new LogicException('Command line executable must be set before calling getProcess().');
        }

        $commandLine = array_merge([$this->exec], $this->args);
        $process = new Process($commandLine, $this->cwd, $this->env);

        if ($this->inheritEnv) {
            $process->inheritEnvironmentVariables();
        }

        return $process;
    }
}
