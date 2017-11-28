<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Compose extends Component
{
    /**
     * @var null|string
     */
    private $composeFile;

    /**
     * @param null|string $binPath
     * @param null|LoggerInterface $logger
     */
    public function __construct($binPath = null, LoggerInterface $logger = null)
    {
        parent::__construct($binPath ?: 'docker-compose', $logger);
    }

    /**
     * @param string $configFile
     *
     * @return $this
     */
    public function withFile($configFile)
    {
        $clone = clone $this;

        return $clone->setComposeFile($configFile);
    }

    /**
     * @param string $composeFile
     *
     * @return $this
     */
    public function setComposeFile($composeFile)
    {
        $this->composeFile = $composeFile;

        return $this;
    }

    /**
     * @todo 'up' should come in two styles:
     * @todo - detached: process keeps running after shutdown and no output is read
     * @todo - attached: process stops at shutdown and output is logged / handle
     */

    /**
     * @param null|string $removeImages Either 'local' or 'all', see `docker-compose down --help` for more info.
     * @param bool $removeVolumes True to remove volumes as well.
     *
     * @return $this Returns current instance, for method chaining.
     */
    public function down($removeImages = null, $removeVolumes = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($this->composeFile);
        }

        $builder->add('down');

        if ($removeImages) {
            $builder->add('--rmi')->add($removeImages);
        }

        if ($removeVolumes) {
            $builder->add('--volumes');
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        $process->mustRun(); // TODO handle output

        return $this;
    }

    /**
     * @param bool $noCache
     * @param bool $forceRemove
     * @param bool $forcePull
     *
     * @return $this Returns current instance, for method chaining.
     */
    public function build($noCache = false, $forceRemove = false, $forcePull = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($this->composeFile);
        }

        $builder->add('build');

        if ($noCache) {
            $builder->add('--no-cache');
        }

        if ($forceRemove) {
            $builder->add('--force-rm');
        }

        if ($forcePull) {
            $builder->add('--pull');
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        $process->mustRun(); // TODO handle output

        return $this;
    }

    /**
     * @param bool $stopContainers
     * @param bool $removeVolumes
     *
     * @return $this Returns current instance, for method chaining.
     */
    public function remove($stopContainers = false, $removeVolumes = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($this->composeFile);
        }

        $builder->add('rm');

        // doesn't make sense to prompt
        $builder->add('--force');

        if ($stopContainers) {
            $builder->add('--stop');
        }

        if ($removeVolumes) {
            $builder->add('-v');
        }

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        $process->mustRun(); // TODO handle output

        return $this;
    }

    /**
     * @param string $service The name of the service from the docker file where the command will execute.
     * @param string $command The command(s) to run. Multiple commands can be joined with '&&' (stop on first failure), '||' (stop on first success) or ';' (ignore failures) as appropriate.
     * @param bool $background Runs the command in the background (command output won't be logged).
     * @param bool $isPrivileged
     * @param null|string $asUser
     * @param bool $noTty Disables pseudo-TTY (enabled by default since it's more often needed).
     *
     * @return $this Returns current instance, for method chaining.
     */
    public function execute($service, $command, $background = false, $isPrivileged = false, $asUser = null, $noTty = true)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($this->composeFile);
        }

        $builder->add('exec');

        if ($background) {
            $builder->add('-d');
        }

        if ($noTty) {
            $builder->add('-T');
        }

        if ($isPrivileged) {
            $builder->add('--privileged');
        }

        if ($asUser) {
            $builder->add('--user')->add($asUser);
        }

        $builder->add($service);

        $builder->add('sh')->add('-c')->add($command);

        $process = $builder->getProcess();

        $this->logger->debug('> ' . $process->getCommandLine());

        $process->mustRun(); // TODO handle output

        return $this;
    }
}
