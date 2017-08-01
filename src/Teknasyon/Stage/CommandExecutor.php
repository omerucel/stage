<?php

namespace Teknasyon\Stage;

use Symfony\Component\Process\Process;

class CommandExecutor
{
    /**
     * @param array $args
     * @return Process
     */
    public function execute(array $args = [])
    {
        $process = new Process(implode(' ', $args));
        $process->start();
        $process->wait();
        return $process;
    }
}
