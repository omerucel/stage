<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommand extends CommandAbstract implements Command
{
    public function run()
    {
        foreach ($this->build->suiteSetting->outputDir as $outputDir) {
            $cmd = [
                'cp',
                '-r',
                $this->build->getBuildDir() . '/' . $outputDir,
                $this->build->getOutputDir() . '/' . $outputDir,
            ];
            $process = $this->commandExecutor->execute($cmd);
            if ($process->getExitCode() < 0) {
                throw new \Exception();
            }
        }
    }
}
