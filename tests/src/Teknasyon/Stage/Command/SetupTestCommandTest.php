<?php

namespace Teknasyon\Stage\Command;

class SetupTestCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'cp',
                    '-r',
                    '/sourcecode',
                    $build->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(2))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupTestCommand($build, $commandExecutor))->run();
    }

    public function testExitCode()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new SetupTestCommand($build, $commandExecutor))->run();
    }

    public function testMultipleOutputDirSupport()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(2))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new SetupTestCommand($build, $commandExecutor))->run();
    }
}
