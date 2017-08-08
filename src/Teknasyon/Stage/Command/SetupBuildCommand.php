<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

class SetupBuildCommand extends CommandAbstract implements Command
{
    /**
     * @param Job $job
     * @throws \Exception
     */
    public function run(Job $job)
    {
        $cmd = [
            'cp',
            '-r',
            $job->suiteSetting->sourceCodeDir,
            $job->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
        $cmd = [
            'mkdir',
            '-p'
        ];
        foreach ($job->suiteSetting->outputDir as $outputDir) {
            $cmd[] = $job->getBuildDir() . '/' . $outputDir;
            $cmd[] = $job->getOutputDir() . '/' . $outputDir;
        }
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
