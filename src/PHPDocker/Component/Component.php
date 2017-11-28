<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

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
     * @var string[]
     */
    private $binCommands;

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
        }
        throw new \RuntimeException('Could not determine version.');
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        try {
            return (bool) $this->getVersion();
        } catch (ProcessFailedException $ex) {
            return false;
        }
    }

    /**
     * Caution! This method gives a rough idea of functionality as reported by the console
     * app, however the program itself could support a different set of commands.
     *
     * @param string[] $parentCommands get sub-commands of this command path (mostly internal use only)
     *
     * @return array the key is the command, the value is the description
     */
    public function getCommands($parentCommands = [])
    {
        if ($this->binCommands === null) {
            $start = microtime(true);
            $this->logger->debug(
                sprintf(
                    '%s->getCommands([%s])...',
                    basename(get_class($this)),
                    implode(', ', $parentCommands)
                )
            );

            $builder = $this->getProcessBuilder();
            $builder->add('help');
            array_map([$builder, 'add'], $parentCommands);

            $process = $builder->getProcess();
            $process->mustRun();
            $output = $process->getOutput() ?: $process->getErrorOutput();

            $this->logger->debug(
                sprintf(
                    '%s->getCommands([%s]) EXEC %.3fs',
                    basename(get_class($this)),
                    implode(', ', $parentCommands),
                    microtime(true) - $start
                )
            );

            $offset = 0;
            $result = [];
            while (preg_match('/^.*Commands:\\r?\\n((  ([\\w-]+)\\s+(.+)\\r?\\n)+)/m',
                $output, $matches, PREG_OFFSET_CAPTURE, $offset)) {
                $offset = $matches[1][1];

                if (preg_match_all('/^  ([\\w-]+)\\s+(.+)$/m', $matches[1][0],
                    $matches)
                ) {
                    list(, $commands, $descriptions) = $matches;

                    $commandPath = implode(' ', $parentCommands) . ' ';
                    $commands = array_map(function ($command) use (
                        $commandPath
                    ) {
                        return trim($commandPath . $command);
                    }, $commands);

                    // add current list of commands
                    $result = array_merge($result,
                        array_combine($commands, $descriptions));

                    // add any sub-commands
                    foreach ($commands as $command) {
                        $result = array_merge($result,
                            $this->getCommands(explode(' ', $command)));
                    }
                }
            }

            if (!count($result) && !count($parentCommands)) {
                throw new \RuntimeException('Could not retrieve list of commands.');
            }

            $this->binCommands = $result;

            $this->logger->debug(
                sprintf(
                    '%s->getCommands([%s]) DONE %.3fs',
                    basename(get_class($this)),
                    implode(', ', $parentCommands),
                    microtime(true) - $start
                )
            );
        }

        return $this->binCommands;
    }

    /**
     * Clears the cache holding the result of `getCommands()`.
     */
    public function clearCommandsCache()
    {
        $this->binCommands = null;
    }

    /**
     * @return ProcessBuilder
     */
    protected function getProcessBuilder()
    {
        return ProcessBuilder::create([$this->bin]);
    }
}
