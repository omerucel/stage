<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class DockerComposeRunCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerComposeBin,
            '-p',
            $job->getGeneratedId(),
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerComposeFile,
            'run',
            $job->suiteSetting->serviceName,
            $job->suiteSetting->command
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
