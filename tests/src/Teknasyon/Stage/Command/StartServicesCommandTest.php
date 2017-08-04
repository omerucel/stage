<?php

namespace Teknasyon\Stage\Command;

class StartServicesCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $build->getGeneratedId(),
                    '-f',
                    $build->getBuildDir() . '/docker-compose.yml',
                    'up',
                    '-d',
                    '--build'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new StartServicesCommand($build, $commandExecutor))->run();
    }

    public function testExitCode()
    {
        $build = $this->getDockerComposeBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new StartServicesCommand($build, $commandExecutor))->run();
    }
}
