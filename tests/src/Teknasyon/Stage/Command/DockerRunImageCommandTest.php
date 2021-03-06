<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class DockerRunImageCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerImageJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'run',
                    '--rm',
                    '--name',
                    $job->getGeneratedId(),
                    '-v',
                    $job->getBuildDir() . ':/app',
                    $job->suiteSetting->dockerimage,
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunImageCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerImageJob();
        $commandExecutor = $this->getCommandExecutor();
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->expects($this->at(0))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerRunImageCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerImageJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args, $listener) {
                $listener('type1', 'buffer1');
            });
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->expects($this->at(1))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, ProcessOutputEvent $event) use ($job) {
                $this->assertEquals(ProcessOutputEvent::NAME, $eventName);
                $this->assertEquals('buffer1', $event->getBuffer());
                $this->assertEquals('type1', $event->getType());
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerRunImageCommand($commandExecutor, $eventDispatcher))->run($job);
    }
}
