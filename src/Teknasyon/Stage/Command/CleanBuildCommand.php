<?php

namespace Teknasyon\Stage\Command;

class CleanBuildCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            'rm',
            '-rf',
            $this->build->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
