<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
use Teknasyon\Stage\Job\Job;

class DockerBuildCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'build',
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerfile,
            '-t',
            $job->getGeneratedId(),
            dirname($job->getBuildDir() . '/' . $job->suiteSetting->dockerfile)
        ];
        $event = new CmdExecuteEvent($cmd, $job);
        $this->eventDispatcher->dispatch($event::NAME, $event);
        $this->commandExecutor->execute($cmd, function ($type, $buffer) use ($job) {
            $event = new ProcessOutputEvent($type, $buffer, $job);
            $this->eventDispatcher->dispatch($event::NAME, $event);
        });
    }
}
