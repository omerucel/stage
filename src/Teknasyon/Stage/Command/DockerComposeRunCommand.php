<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerComposeRunCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            $suite->environmentSetting->dockerComposeBin,
            '-p',
            $suite->getGeneratedId(),
            '-f',
            $suite->getBuildDir() . '/' . $suite->suiteSetting->dockerComposeFile,
            'run',
            $suite->suiteSetting->serviceName,
            $suite->suiteSetting->command
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
