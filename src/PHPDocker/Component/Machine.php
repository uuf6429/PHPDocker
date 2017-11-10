<?php

namespace PHPDocker\Component;

use Psr\Log\LoggerInterface;

class Machine extends Component
{
    /**
     * @param null|string $binPath
     * @param null|LoggerInterface $logger
     */
    public function __construct($binPath = null, LoggerInterface $logger = null)
    {
        parent::__construct($binPath ?: 'docker-machine', $logger);
    }
}
