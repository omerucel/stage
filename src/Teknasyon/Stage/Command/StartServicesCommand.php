<?php

namespace Teknasyon\Stage\Command;

class StartServicesCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $args = [
            $this->build->environmentSetting->dockerComposeBin,
            '-p',
            $this->build->id,
            '-f',
            $this->build->dockerComposeFile,
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
