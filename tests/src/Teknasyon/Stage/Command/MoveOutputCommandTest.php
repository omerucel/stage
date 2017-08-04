<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommandTest extends CommandTestAbstract
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
                    $build->getBuildDir() . '/tmp/output',
                    $build->getOutputDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'cp',
                    '-r',
                    $build->getBuildDir() . '/logs',
                    $build->getOutputDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new MoveOutputCommand($build, $commandExecutor))->run();
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
        (new MoveOutputCommand($build, $commandExecutor))->run();
    }
}
