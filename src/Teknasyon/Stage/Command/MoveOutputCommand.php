<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class MoveOutputCommand extends CommandAbstract implements Command
{
    public function run(Suite $suite)
    {
        foreach ($suite->suiteSetting->outputDir as $outputDir) {
            $cmd = [
                'cp',
                '-r',
                $suite->getBuildDir() . '/' . $outputDir,
                $suite->getOutputDir() . '/' . $outputDir,
            ];
            $process = $this->commandExecutor->execute($cmd);
            if ($process->getExitCode() < 0) {
                throw new \Exception();
            }
        }
    }
}
