<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerComposeRmCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerComposeBin,
            '-p',
            $job->getGeneratedId(),
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerComposeFile,
            'rm',
            '--force',
            '--stop'
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
