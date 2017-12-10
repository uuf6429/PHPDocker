<?php

namespace PHPDocker\Component;

use PHPDocker\ProcessBuilder;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Process\Exception\ProcessFailedException;

abstract class Component
{
    /**
     * @var string
     */
    private $bin;

    /**
     * @var null|array
     */
    private $env;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var callable
     */
    protected $outputHandler;

    /**
     * @var string[]
     */
    private $binCommands;

    /**
     * @param null|string $binPath
     * @param null|array $envVars
     * @param null|LoggerInterface $logger
     * @param null|callable $outputHandler
     */
    public function __construct(
        $binPath = null,
        array $envVars = null,
        LoggerInterface $logger = null,
        callable $outputHandler = null
    ) {
        if (!$binPath) {
            throw new \InvalidArgumentException('Argument $binPath must not be empty.');
        }

        $this->bin = $binPath;
        $this->env = $envVars;
        $this->logger = $logger ?: new NullLogger();
        $this->setOutputHandler($outputHandler);
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
     * @param bool $ignoreCache ignore cached commands and run anyway
     *
     * @return array the key is the command, the value is the description
     */
    public function getCommands($ignoreCache = false)
    {
        static $commandPathProp = 'commandPath';

        if ($ignoreCache || $this->binCommands === null) {
            $this->binCommands = [];
            $process = $this->getProcessBuilder()->add('help')->getProcess();
            $processList = [$process];
            $process->$commandPathProp = []; // first command has no parents
            $process->start();

            while (!empty(array_filter($processList))) {
                foreach ($processList as $i => $process) {
                    /** @var \Symfony\Component\Process\Process $process */
                    if ($process && !$process->isRunning()) {
                        // process exited, remove it from list
                        $processList[$i] = null;

                        if ($process->getExitCode()) {
                            // process failed for some reason, log error and continue
                            $this->logger->warning(
                                sprintf(
                                    "Process exited with status %s:\nCommand: %s\nStdOut: %s\nStdErr: %s",
                                    $process->getExitCode(),
                                    $process->getCommandLine(),
                                    $process->getOutput(),
                                    $process->getErrorOutput()
                                )
                            );
                        } else {
                            // process successful, parse output, add new commands and inspect them too
                            $output = $process->getOutput() ?: $process->getErrorOutput();
                            $offset = 0;
                            $pattern = '/^.*Commands:\\r?\\n((  ([\\w-]+)\\s+(.+)\\r?\\n)+)/m';

                            while (preg_match($pattern, $output, $matches, PREG_OFFSET_CAPTURE, $offset)) {
                                $offset = $matches[1][1];

                                if (preg_match_all('/^  ([\\w-]+)\\s+(.+)$/m', $matches[1][0], $matches)) {
                                    list(, $commands, $descriptions) = $matches;

                                    foreach (array_combine($commands, $descriptions) as $command => $description) {
                                        $newCommandPath = array_merge($process->$commandPathProp, [trim($command)]);

                                        $this->binCommands[implode(' ', $newCommandPath)] = trim($description);

                                        $builder = $this->getProcessBuilder()->add('help');
                                        array_map([$builder, 'add'], $newCommandPath);
                                        $newProcess = $builder->getProcess();
                                        $processList[] = $newProcess;
                                        $newProcess->$commandPathProp = $newCommandPath;
                                        $newProcess->start();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // sort results naturally (by key)
            array_multisort(array_keys($this->binCommands), SORT_NATURAL, $this->binCommands);
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
     * @param callable $outputHandler
     *
     * @return static new instance using the specified output handler
     */
    public function withOutputHandler(callable $outputHandler)
    {
        $copy = clone $this;

        return $copy->setOutputHandler($outputHandler);
    }

    /**
     * @return ProcessBuilder
     */
    protected function getProcessBuilder()
    {
        $builder = ProcessBuilder::create($this->bin);

        if ($this->env) {
            $builder->addEnvVars($this->env);
        }

        return $builder;
    }

    /**
     * @param callable|null $userOutputHandler
     *
     * @return $this
     */
    protected function setOutputHandler(callable $userOutputHandler = null)
    {
        $this->outputHandler = function ($type, $text) use ($userOutputHandler) {
            switch ($type) {
                case ProcessBuilder::OUT:
                    $this->logger->info("OUT $text");
                    break;
                case ProcessBuilder::ERR:
                    $this->logger->error("OUT $text");
                    break;
                default:
                    $this->logger->warning("UNK $text");
                    break;
            }

            if ($userOutputHandler) {
                $userOutputHandler($type, $text);
            }
        };

        return $this;
    }
}
