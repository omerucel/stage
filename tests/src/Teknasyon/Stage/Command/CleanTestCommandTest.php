<?php

namespace Teknasyon\Stage\Command;

class CleanTestCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'rm',
                    '-rf',
                    $build->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new CleanTestCommand($build, $commandExecutor))->run();
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
        (new CleanTestCommand($build, $commandExecutor))->run();
    }
}
