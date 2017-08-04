<?php

namespace Teknasyon\Stage\Command;

class StopServicesCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $build->getGeneratedId(),
                    '-f',
                    $build->getBuildDir() . '/docker-compose.yml',
                    'rm',
                    '--force',
                    '--stop'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new StopServicesCommand($build, $commandExecutor))->run();
    }

    public function testExitCode()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new StopServicesCommand($build, $commandExecutor))->run();
    }
}
