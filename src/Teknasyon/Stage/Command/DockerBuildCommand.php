<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerBuildCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            $suite->environmentSetting->dockerBin,
            'build',
            '-f',
            $suite->getBuildDir() . '/' . $suite->suiteSetting->dockerfile,
            '-t',
            $suite->getGeneratedId(),
            dirname($suite->getBuildDir() . '/' . $suite->suiteSetting->dockerfile)
        ];
        $this->commandExecutor->execute($cmd);
    }
}
