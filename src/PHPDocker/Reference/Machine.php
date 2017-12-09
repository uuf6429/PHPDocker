<?php

namespace PHPDocker\Reference;

use PHPDocker\Component\Machine as MachineComponent;
use PHPDocker\Manager;

class Machine
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var MachineComponent
     */
    private $machine;

    /**
     * @param string $name name of machine
     * @param null|MachineComponent $machine DockerMachine instance for performing operations
     */
    public function __construct($name, MachineComponent $machine = null)
    {
        $this->name = $name;
        $this->machine = $machine ?: (new Manager())->machine;
    }

    /**
     * Returns true if this machine is the currently active one.
     *
     * @return bool
     */
    public function active()
    {
        return $this->machine->getActive() === $this->name;
    }

    /**
     * @todo
     */
    public function config()
    {
    }

    /**
     * @todo
     */
    public function create()
    {
    }

    /**
     * Returns environment variables that docker needs to use this machine.
     *
     * @return array
     */
    public function getEnvVars()
    {
        return $this->machine->getEnvVars($this->name);
    }

    /**
     * @todo
     */
    public function inspect()
    {
    }

    /**
     * Returns the IP for this machine.
     *
     * @return string
     */
    public function getIP()
    {
        return $this->machine->getIPs([$this->name])[0];
    }

    /**
     * Kills this machine.
     *
     * @return $this current instance, for method chaining
     */
    public function kill()
    {
        $this->machine->kill([$this->name]);

        return $this;
    }

    /**
     * @todo
     */
    public function provision()
    {
    }

    /**
     * Restarts this machine.
     *
     * @return $this current instance, for method chaining
     */
    public function restart()
    {
        $this->machine->restart([$this->name]);

        return $this;
    }

    /**
     * Removes this machine.
     *
     * @param bool $forcedRemoval If true, machine config is removed even if machine cannot be removed
     *
     * @return $this current instance, for method chaining
     */
    public function remove($forcedRemoval = false)
    {
        $this->machine->remove([$this->name], $forcedRemoval);

        return $this;
    }

    /**
     * @todo
     */
    public function ssh()
    {
    }

    /**
     * @todo
     */
    public function scp()
    {
    }

    /**
     * Starts this machine.
     *
     * @return $this current instance, for method chaining
     */
    public function start()
    {
        $this->machine->start([$this->name]);

        return $this;
    }

    /**
     * Returns status of this machine.
     *
     * @return string machine status, see Manager::$machine::STATE_* constants for possible values
     */
    public function getStatus()
    {
        return $this->machine->getStatus([$this->name]);
    }

    /**
     * Stops this machine.
     *
     * @return $this current instance, for method chaining
     */
    public function stop()
    {
        $this->machine->stop([$this->name]);

        return $this;
    }

    /**
     * Upgrades this machine.
     *
     * @return $this current instance, for method chaining
     */
    public function upgrade()
    {
        $this->machine->upgrade([$this->name]);

        return $this;
    }

    /**
     * Returns URL for this machine.
     *
     * @return string
     */
    public function url()
    {
        return $this->machine->getURL($this->name);
    }

    /**
     * Returns the name of this container.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the DockerMachine instance used by this machine.
     *
     * @return MachineComponent
     */
    public function getMachine()
    {
        return $this->machine;
    }

    /**
     * @param MachineComponent $machine the new Docker instance to use
     *
     * @return self new instance using the specified docker instance
     */
    public function withDocker(MachineComponent $machine)
    {
        $clone = clone $this;

        return $clone->setMachine($machine);
    }

    /**
     * @param MachineComponent $machine
     *
     * @return $this current instance, for method chaining
     */
    protected function setMachine(MachineComponent $machine)
    {
        $this->machine = $machine;

        return $this;
    }
}
