<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
use Teknasyon\Stage\Job\Job;

class DockerStopCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerBin,
            'rmi',
            $job->getGeneratedId()
        ];
        $event = new CmdExecuteEvent($cmd, $job);
        $this->eventDispatcher->dispatch($event::NAME, $event);
        $this->commandExecutor->execute($cmd, function ($type, $buffer) use ($job) {
            $event = new ProcessOutputEvent($type, $buffer, $job);
            $this->eventDispatcher->dispatch($event::NAME, $event);
        });
    }
}
