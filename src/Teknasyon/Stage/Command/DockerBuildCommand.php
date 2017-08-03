<?php

namespace Teknasyon\Stage\Command;

class DockerBuildCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerBin,
            'build',
            '-f',
            $this->build->getBuildDir() . '/' . $this->build->suiteSetting->dockerfile,
            '-t',
            $this->build->getGeneratedId(),
            dirname($this->build->getBuildDir() . '/' . $this->build->suiteSetting->dockerfile)
        ];
        $this->commandExecutor->execute($cmd);
    }
}
