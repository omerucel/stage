<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerComposeUpCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $args = [
            $job->environmentSetting->dockerComposeBin,
            '-p',
            $job->getGeneratedId(),
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerComposeFile,
            'up',
            '-d',
            '--build'
        ];
        $process = $this->commandExecutor->execute($args);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
