<?php

namespace Teknasyon\Stage\Command;

class DockerBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $build = $this->getDockerfileBuild();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker',
                    'build',
                    '-f',
                    $build->getBuildDir() . '/Dockerfile',
                    '-t',
                    $build->getGeneratedId(),
                    $build->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerBuildCommand($build, $commandExecutor))->run();
    }
}
