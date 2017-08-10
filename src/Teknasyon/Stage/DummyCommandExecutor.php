<?php

namespace Teknasyon\Stage;

use Symfony\Component\Process\Process;

class DummyCommandExecutor extends CommandExecutor
{
    /**
     * @param array $args
     * @param \Closure|null $listener
     * @return Process
     */
    public function execute(array $args = [], \Closure $listener = null)
    {
        echo implode(' ', $args) . PHP_EOL;
        $process = new Process($args);
        return $process;
    }
}
