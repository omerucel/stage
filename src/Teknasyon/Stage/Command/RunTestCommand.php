<?php

namespace Teknasyon\Stage\Command;

class RunTestCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerComposeBin,
            '-p',
            $this->build->getGeneratedId(),
            '-f',
            $this->build->getBuildDir() . '/' . $this->build->suiteSetting->dockerComposeFile,
            'run',
            $this->build->suiteSetting->serviceName,
            $this->build->suiteSetting->command
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
