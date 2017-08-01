<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommand extends CommandAbstract implements Command
{
    public function run()
    {
        $cmd = [
            'cp',
            '-r',
            $this->build->buildDir . '/' . $this->build->suiteSetting->outputDir,
            $this->build->outputDir,
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
