<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerComposeUpCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $args = [
            $suite->environmentSetting->dockerComposeBin,
            '-p',
            $suite->getGeneratedId(),
            '-f',
            $suite->getBuildDir() . '/' . $suite->suiteSetting->dockerComposeFile,
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
