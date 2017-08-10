<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class CleanBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    'rm',
                    '-rf',
                    $job->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new CleanBuildCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerComposeJob();
        $eventDispatcher = $this->getEventDispatcher();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(0);
            });
        $eventDispatcher->expects($this->at(0))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new CleanBuildCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerComposeJob();
        $eventDispatcher = $this->getEventDispatcher();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args, $listener) {
                $listener('type1', 'buffer1');
                return $this->generateProcessWithExitCode(0);
            });
        $eventDispatcher->expects($this->at(1))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, ProcessOutputEvent $event) use ($job) {
                $this->assertEquals(ProcessOutputEvent::NAME, $eventName);
                $this->assertEquals('type1', $event->getType());
                $this->assertEquals('buffer1', $event->getBuffer());
                $this->assertEquals($job, $event->getJob());
            });
        (new CleanBuildCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testExitCode()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new CleanBuildCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }
}
