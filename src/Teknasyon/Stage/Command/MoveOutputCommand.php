<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            'cp',
            '-r',
            $this->build->getBuildDir() . '/' . $this->build->suiteSetting->outputDir,
            $this->build->getOutputDir(),
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
