<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerComposeRmCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            $suite->environmentSetting->dockerComposeBin,
            '-p',
            $suite->getGeneratedId(),
            '-f',
            $suite->getBuildDir() . '/' . $suite->suiteSetting->dockerComposeFile,
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
