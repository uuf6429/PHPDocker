<?php

namespace PHPDocker\Reference;

use PHPDocker\Component\Docker;
use PHPDocker\Manager;

class Container
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Docker
     */
    private $docker;

    /**
     * @param string $name name of container
     * @param null|Docker $docker docker instance for performing operations
     */
    public function __construct($name, Docker $docker = null)
    {
        $this->name = $name;
        $this->docker = $docker ?: (new Manager())->docker;
    }

    /**
     * @param Docker $docker the new Docker instance to use
     *
     * @return self new instance using the specified docker instance
     */
    public function withDocker(Docker $docker)
    {
        $clone = clone $this;

        return $clone->setDocker($docker);
    }

    /**
     * @see \PHPDocker\Component\Docker::attach()
     *
     * @return $this Current instance, for method chaining
     */
    public function attach(/* TODO */)
    {
        $this->docker->attach($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::commit()
     *
     * @return $this Current instance, for method chaining
     */
    public function commit(/* TODO */)
    {
        $this->docker->commit($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::copy()
     *
     * @param string $sourcePath
     * @param string $targetPath
     *
     * @return $this Current instance, for method chaining
     */
    public function copy($sourcePath, $targetPath)
    {
        $this->docker->copy($this->name, $sourcePath, $targetPath);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::diff()
     *
     * @return $this Current instance, for method chaining
     */
    public function diff(/* TODO */)
    {
        $this->docker->diff($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::exec()
     *
     * @return $this Current instance, for method chaining
     */
    public function exec(/* TODO */)
    {
        $this->docker->exec($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::export()
     *
     * @return $this Current instance, for method chaining
     */
    public function export(/* TODO */)
    {
        $this->docker->export($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::kill()
     *
     * @return $this Current instance, for method chaining
     */
    public function kill(/* TODO */)
    {
        $this->docker->kill($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::logs()
     *
     * @return $this Current instance, for method chaining
     */
    public function logs(/* TODO */)
    {
        $this->docker->logs($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::pause()
     *
     * @return $this Current instance, for method chaining
     */
    public function pause(/* TODO */)
    {
        $this->docker->pause($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::port()
     *
     * @return $this Current instance, for method chaining
     */
    public function port(/* TODO */)
    {
        $this->docker->port($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::rename()
     *
     * @return $this Current instance, for method chaining
     */
    public function rename(/* TODO */)
    {
        $this->docker->rename($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::restart()
     *
     * @return $this Current instance, for method chaining
     */
    public function restart(/* TODO */)
    {
        $this->docker->restart($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::remove()
     *
     * @param bool $forceRemove
     * @param bool $removeVolumes
     *
     * @return $this Current instance, for method chaining
     */
    public function remove($forceRemove = false, $removeVolumes = false)
    {
        $this->docker->remove($this->name, $forceRemove, $removeVolumes);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::resume()
     *
     * @return $this Current instance, for method chaining
     */
    public function resume(/* TODO */)
    {
        $this->docker->resume($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::start()
     *
     * @return $this Current instance, for method chaining
     */
    public function start(/* TODO */)
    {
        $this->docker->start($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::stop()
     *
     * @return $this Current instance, for method chaining
     */
    public function stop(/* TODO */)
    {
        $this->docker->stop($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::top()
     *
     * @return $this Current instance, for method chaining
     */
    public function top(/* TODO */)
    {
        $this->docker->top($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::update()
     *
     * @return $this Current instance, for method chaining
     */
    public function update(/* TODO */)
    {
        $this->docker->update($this->name /* TODO */);

        return $this;
    }

    /**
     * @see \PHPDocker\Component\Docker::wait()
     *
     * @return $this Current instance, for method chaining
     */
    public function wait(/* TODO */)
    {
        $this->docker->wait($this->name /* TODO */);

        return $this;
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
     * Returns the docker instance used by this container.
     *
     * @return Docker
     */
    public function getDocker()
    {
        return $this->docker;
    }

    /**
     * @param Docker $docker
     *
     * @return $this
     */
    protected function setDocker(Docker $docker)
    {
        $this->docker = $docker;

        return $this;
    }
}
