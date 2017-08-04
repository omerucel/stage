<?php

namespace Teknasyon\Stage\Command;

class CleanBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'rm',
                    '-rf',
                    $suite->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new CleanBuildCommand($commandExecutor))->run($suite);
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
        (new CleanBuildCommand($commandExecutor))->run($suite);
    }
}
