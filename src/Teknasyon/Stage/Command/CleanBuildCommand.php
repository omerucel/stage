<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class CleanBuildCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            'rm',
            '-rf',
            $suite->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
