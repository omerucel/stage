<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class DockerStopCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'rmi',
                    $job->getGeneratedId()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerStopCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerComposeJob();
        $eventDispatcher = $this->getEventDispatcher();
        $commandExecutor = $this->getCommandExecutor();
        $eventDispatcher->expects($this->at(0))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerStopCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerComposeJob();
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
        (new DockerStopCommand($commandExecutor, $eventDispatcher))->run($job);
    }
}
