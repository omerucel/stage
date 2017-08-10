<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class DockerComposeUpCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $job->getGeneratedId(),
                    '-f',
                    $job->getBuildDir() . '/docker-compose.yml',
                    'up',
                    '-d',
                    '--build'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new DockerComposeUpCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(0);
            });
        $eventDispatcher = $this->getEventDispatcher();
        $eventDispatcher->expects($this->at(0))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new DockerComposeUpCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args, $listener) {
                $listener('type1', 'buffer1');
                return $this->generateProcessWithExitCode(0);
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
        (new DockerComposeUpCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testExitCode()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new DockerComposeUpCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }
}
