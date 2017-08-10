<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
use Teknasyon\Stage\Job\Job;

class DockerRunCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'run',
            '--rm',
            '--name',
            $job->getGeneratedId(),
            '-v',
            $job->getBuildDir() . ':' . $job->suiteSetting->sourceCodeTarget,
            $job->getGeneratedId(),
            $job->suiteSetting->command
        ];
        $event = new CmdExecuteEvent($cmd, $job);
        $this->eventDispatcher->dispatch($event::NAME, $event);
        $this->commandExecutor->execute($cmd, function ($type, $buffer) use ($job) {
            $event = new ProcessOutputEvent($type, $buffer, $job);
            $this->eventDispatcher->dispatch($event::NAME, $event);
        });
    }
}
