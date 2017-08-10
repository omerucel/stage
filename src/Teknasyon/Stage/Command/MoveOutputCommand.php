<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
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
            $event = new CmdExecuteEvent($cmd, $job);
            $this->eventDispatcher->dispatch($event::NAME, $event);
            $process = $this->commandExecutor->execute($cmd, function ($type, $buffer) use ($job) {
                $event = new ProcessOutputEvent($type, $buffer, $job);
                $this->eventDispatcher->dispatch($event::NAME, $event);
            });
            if ($process->getExitCode() < 0) {
                throw new \Exception();
            }
        }
    }
}
