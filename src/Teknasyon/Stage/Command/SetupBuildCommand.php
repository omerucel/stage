<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

class SetupBuildCommand extends CommandAbstract implements Command
{
    /**
     * @param Suite $suite
     * @throws \Exception
     */
    public function run(Suite $suite)
    {
        $cmd = [
            'cp',
            '-r',
            $suite->suiteSetting->sourceCodeDir,
            $suite->getBuildDir()
        ];
        $process = $this->commandExecutor->execute($cmd);
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
        foreach ($suite->suiteSetting->outputDir as $outputDir) {
            $cmd = [
                'mkdir',
                '-p',
                $suite->getBuildDir() . '/' . $outputDir
            ];
            $process = $this->commandExecutor->execute($cmd);
            if ($process->getExitCode() < 0) {
                throw new \Exception();
            }
        }
    }
}
