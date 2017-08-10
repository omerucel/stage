<?php

namespace Teknasyon\Stage\Command;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknasyon\Stage\CommandExecutor;

abstract class CommandAbstract
{
    /**
     * @var CommandExecutor
     */
    protected $commandExecutor;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @param CommandExecutor $commandExecutor
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(CommandExecutor $commandExecutor, EventDispatcher $eventDispatcher)
    {
        $this->commandExecutor = $commandExecutor;
        $this->eventDispatcher = $eventDispatcher;
    }
}
