<?php

namespace Teknasyon\Stage\Command;

class DockerRunCommandTest extends CommandTestAbstract
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
                    'run',
                    '--rm',
                    '--name',
                    $build->getGeneratedId(),
                    '-v',
                    $build->getBuildDir() . ':/app',
                    $build->getGeneratedId(),
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunCommand($build, $commandExecutor))->run();
    }
}
