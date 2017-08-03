<?php

namespace Teknasyon\Stage\Command;

class DockerStopCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerBin,
            'rmi',
            $this->build->getGeneratedId()
        ];
        $this->commandExecutor->execute($cmd);
    }
}
