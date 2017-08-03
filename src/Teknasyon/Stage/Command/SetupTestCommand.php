<?php

namespace Teknasyon\Stage\Command;

class SetupTestCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            'cp',
            '-r',
            $this->build->projectSetting->sourceCodeDir,
            $this->build->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
        $cmd = [
            'mkdir',
            '-p',
            $this->build->getBuildDir() . '/' . $this->build->suiteSetting->outputDir
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
