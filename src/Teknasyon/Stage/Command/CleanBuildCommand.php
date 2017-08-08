<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class CleanBuildCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            'rm',
            '-rf',
            $job->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
