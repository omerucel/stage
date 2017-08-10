<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
use Teknasyon\Stage\Job\Job;

class DockerComposeRunCommand extends CommandAbstract implements Command
{
    public function run(Job $job)
    {
        $cmd = [
            $job->environmentSetting->dockerComposeBin,
            '-p',
            $job->getGeneratedId(),
            '-f',
            $job->getBuildDir() . '/' . $job->suiteSetting->dockerComposeFile,
            'run',
            $job->suiteSetting->serviceName,
            $job->suiteSetting->command
        ];
        $event = new CmdExecuteEvent($cmd, $job);
        $this->eventDispatcher->dispatch($event::NAME, $event);
        $process = $this->commandExecutor->execute($cmd, function ($type, $buffer) use ($job) {
            $event = new ProcessOutputEvent($type, $buffer, $job);
            $this->eventDispatcher->dispatch($event::NAME, $event);
        });;
        if ($process->getExitCode() < 0) {
            throw new \Exception();
        }
    }
}
