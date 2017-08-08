<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerRunImageCommand extends CommandAbstract implements Command
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
            $job->suiteSetting->dockerimage,
            $job->suiteSetting->command
        ];
        $this->commandExecutor->execute($cmd);
    }
}
