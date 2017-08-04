<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class DockerStopCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        $cmd = [
            $suite->environmentSetting->dockerBin,
            'rmi',
            $suite->getGeneratedId()
        ];
        $this->commandExecutor->execute($cmd);
    }
}
