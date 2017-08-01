<?php

namespace Teknasyon\Stage\Command;

class CleanTestCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            'rm',
            '-rf',
            $this->build->buildDir
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
