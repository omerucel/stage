<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerRunCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            $suite->environmentSetting->dockerBin,
            'run',
            '--rm',
            '--name',
            $suite->getGeneratedId(),
            '-v',
            $suite->getBuildDir() . ':' . $suite->suiteSetting->sourceCodeTarget,
            $suite->getGeneratedId(),
            $suite->suiteSetting->command
        ];
        $this->commandExecutor->execute($cmd);
    }
}
