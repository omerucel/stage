<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class MoveOutputCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    'cp',
                    '-r',
                    $job->getBuildDir() . '/tmp/output',
                    $job->getOutputDir() . '/tmp'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    'cp',
                    '-r',
                    $job->getBuildDir() . '/logs',
                    $job->getOutputDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new MoveOutputCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
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
        $eventDispatcher->expects($this->at(1))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, CmdExecuteEvent $event) use ($job) {
                $this->assertEquals(CmdExecuteEvent::NAME, $eventName);
                $this->assertEquals($job, $event->getJob());
            });
        (new MoveOutputCommand($commandExecutor, $eventDispatcher))->run($job);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args, $listener) {
                $listener('type1', 'buffer1');
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args, $listener) {
                $listener('type2', 'buffer2');
                return $this->generateProcessWithExitCode(0);
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
        $eventDispatcher->expects($this->at(3))
            ->method('dispatch')
            ->willReturnCallback(function ($eventName, ProcessOutputEvent $event) use ($job) {
                $this->assertEquals(ProcessOutputEvent::NAME, $eventName);
                $this->assertEquals('buffer2', $event->getBuffer());
                $this->assertEquals('type2', $event->getType());
                $this->assertEquals($job, $event->getJob());
            });
        (new MoveOutputCommand($commandExecutor, $eventDispatcher))->run($job);
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
        (new MoveOutputCommand($commandExecutor, $this->getEventDispatcher()))->run($job);
    }
}
