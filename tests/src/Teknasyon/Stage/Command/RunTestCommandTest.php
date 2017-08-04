<?php

namespace Teknasyon\Stage\Command;

class RunTestCommandTest extends CommandTestAbstract
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
                    'run',
                    'app',
                    'sh /data/project/test.sh'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new RunTestCommand($build, $commandExecutor))->run();
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
        (new RunTestCommand($build, $commandExecutor))->run();
    }
}
