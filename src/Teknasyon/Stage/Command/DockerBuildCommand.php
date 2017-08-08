<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerBuildCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'build',
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerfile,
            '-t',
            $job->getGeneratedId(),
            dirname($job->getBuildDir() . '/' . $job->suiteSetting->dockerfile)
        ];
        $this->commandExecutor->execute($cmd);
    }
}
