<?php

namespace Teknasyon\Stage\Command;

class StopServicesCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerComposeBin,
            '-p',
            $this->build->getGeneratedId(),
            '-f',
            $this->build->getBuildDir() . '/' . $this->build->suiteSetting->dockerComposeFile,
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
