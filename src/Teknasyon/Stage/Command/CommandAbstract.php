<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Build;
use Teknasyon\Stage\CommandExecutor;

abstract class CommandAbstract
{
    /**
     * @var Build
     */
    protected $build;

    /**
     * @var CommandExecutor
     */
    protected $commandExecutor;

    /**
     * @param Build $build
     * @param CommandExecutor $commandExecutor
     */
    public function __construct(Build $build, CommandExecutor $commandExecutor)
    {
        $this->build = $build;
        $this->commandExecutor = $commandExecutor;
    }
}
