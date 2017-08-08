<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class MoveOutputCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        foreach ($job->suiteSetting->outputDir as $outputDir) {
            $cmd = [
                'cp',
                '-r',
                $job->getBuildDir() . '/' . $outputDir,
                dirname($job->getOutputDir() . '/' . $outputDir),
            ];
            $process = $this->commandExecutor->execute($cmd);
            if ($process->getExitCode() < 0) {
                throw new \Exception();
            }
        }
    }
}
