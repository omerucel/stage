<?php

namespace Teknasyon\Stage\Command;

class RunTestCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            $this->build->environmentSetting->dockerComposeBin,
            '-p',
            $this->build->id,
            '-f',
            $this->build->dockerComposeFile,
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
