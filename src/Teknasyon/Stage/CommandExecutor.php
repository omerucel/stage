<?php

namespace Teknasyon\Stage;

use Symfony\Component\Process\Process;

class CommandExecutor
{
    /**
     * @param array $args
     * @param \Closure|null $callback
     * @return Process
     */
    public function execute(array $args = [], \Closure $callback = null)
    {
        $process = new Process(implode(' ', $args));
        $process->start();
        $process->wait($callback);
        return $process;
    }
}
