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
     * @param null|string $file
     * @param null|string $removeImages 'local' or 'all', see `docker-compose down --help` for more info
     * @param bool $removeVolumes
     */
    public function down($file = null, $removeImages = null, $removeVolumes = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($file);
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
    }

    /**
     * @param null $file
     * @param bool $noCache
     * @param bool $forceRemove
     * @param bool $forcePull
     */
    public function build($file = null, $noCache = false, $forceRemove = false, $forcePull = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($file);
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
    }

    public function remove($file = null, $stopContainers = false, $removeVolumes = false)
    {
        $builder = $this->getProcessBuilder();

        if ($this->composeFile) {
            $builder->add('--file')->add($file);
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
    }
}
