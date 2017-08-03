<?php

namespace Teknasyon\Stage\Command;

class DockerRunCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerBin,
            'run',
            '--rm',
            '--name',
            $this->build->getGeneratedId(),
            '-v',
            $this->build->getBuildDir() . ':' . $this->build->suiteSetting->sourceCodeTarget,
            $this->build->getGeneratedId(),
            $this->build->suiteSetting->command
        ];
        $this->commandExecutor->execute($cmd);
    }
}
