<?php

namespace Teknasyon\Stage\Command;

class SetupBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'cp',
                    '-r',
                    '/sourcecode',
                    $suite->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'mkdir',
                    '-p',
                    $suite->getBuildDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(2))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'mkdir',
                    '-p',
                    $suite->getBuildDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupBuildCommand($commandExecutor))->run($suite);
    }

    public function testExitCode()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new SetupBuildCommand($commandExecutor))->run($suite);
    }

    public function testMultipleOutputDirSupport()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'mkdir',
                    '-p',
                    $suite->getBuildDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(2))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'mkdir',
                    '-p',
                    $suite->getBuildDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupBuildCommand($commandExecutor))->run($suite);
    }
}
