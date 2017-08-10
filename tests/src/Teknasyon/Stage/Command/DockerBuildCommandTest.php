<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class DockerBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerfileJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'build',
                    '-f',
                    $job->getBuildDir() . '/Dockerfile',
                    '-t',
                    $job->getGeneratedId(),
                    $job->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerBuildCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerfileJob();
        $commandExecutor = $this->getCommandExecutor();
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->expects($this->at(0))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerBuildCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerfileJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($cmd, $listener) {
                $listener('type1', 'buffer1');
            });
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->expects($this->at(1))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, ProcessOutputEvent $event) use ($job) {
                $this->assertEquals(ProcessOutputEvent::NAME, $eventName);
                $this->assertEquals('type1', $event->getType());
                $this->assertEquals('buffer1', $event->getBuffer());
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerBuildCommand($commandExecutor, $eventDispatcher))->run($job);
    }
}
