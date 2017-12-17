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
     * Creates new image from container.
     *
     * @param null|string $repository repository name, optionally ending with a tag (eg; user/image:tag)
     * @param string[] $changes list of Dockerfile changes to apply to the generate image
     * @param null|string $message message describing this commit
     * @param null|string $author Author, usually including email (eg; "John Doe <john.doe@example.com>").
     * @param null|bool $pause whether to pause container during process or not
     *
     * @return $this Current instance, for method chaining
     */
    public function commit($repository = null, $changes = [], $message = null, $author = null, $pause = null)
    {
        $this->docker->commit($this->name, $repository, $changes, $message, $author, $pause);

        return $this;
    }

    /**
     * @param string $sourcePath source file or directory to copy
     * @param string $targetPath destination where to copy to
     *
     * @return $this current instance, for method chaining
     */
    public function copy($sourcePath, $targetPath)
    {
        $this->docker->copy($this->name, $sourcePath, $targetPath);

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
