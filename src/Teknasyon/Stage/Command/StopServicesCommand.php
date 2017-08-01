<?php

namespace Teknasyon\Stage\Command;

class StopServicesCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerComposeBin,
            '-p',
            $this->build->id,
            '-f',
            $this->build->dockerComposeFile,
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
