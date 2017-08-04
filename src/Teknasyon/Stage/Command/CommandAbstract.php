<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\CommandExecutor;

abstract class CommandAbstract
{
    /**
     * @var CommandExecutor
     */
    protected $commandExecutor;

    /**
     * @param CommandExecutor $commandExecutor
     */
    public function __construct(CommandExecutor $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }
}
