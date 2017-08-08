<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerStopCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'rmi',
            $job->getGeneratedId()
        ];
        $this->commandExecutor->execute($cmd);
    }
}
