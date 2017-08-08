<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerRunCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'run',
            '--rm',
            '--name',
            $job->getGeneratedId(),
            '-v',
            $job->getBuildDir() . ':' . $job->suiteSetting->sourceCodeTarget,
            $job->getGeneratedId(),
            $job->suiteSetting->command
        ];
        $this->commandExecutor->execute($cmd);
    }
}
