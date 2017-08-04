<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommandTest extends CommandTestAbstract
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
                    $suite->getBuildDir() . '/tmp/output',
                    $suite->getOutputDir() . '/tmp'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    'cp',
                    '-r',
                    $suite->getBuildDir() . '/logs',
                    $suite->getOutputDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new MoveOutputCommand($commandExecutor))->run($suite);
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
        (new MoveOutputCommand($commandExecutor))->run($suite);
    }
}
