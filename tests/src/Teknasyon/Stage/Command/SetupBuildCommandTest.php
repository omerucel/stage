<?php

namespace Teknasyon\Stage\Command;

class SetupBuildCommandTest extends CommandTestAbstract
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
                    '/sourcecode',
                    $job->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    'mkdir',
                    '-p',
                    $job->getBuildDir() . '/tmp/output',
                    $job->getOutputDir() . '/tmp/output',
                    $job->getBuildDir() . '/logs',
                    $job->getOutputDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupBuildCommand($commandExecutor))->run($job);
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
        (new SetupBuildCommand($commandExecutor))->run($job);
    }

    public function testMultipleOutputDirSupport()
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
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    'mkdir',
                    '-p',
                    $job->getBuildDir() . '/tmp/output',
                    $job->getOutputDir() . '/tmp/output',
                    $job->getBuildDir() . '/logs',
                    $job->getOutputDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupBuildCommand($commandExecutor))->run($job);
    }
}
