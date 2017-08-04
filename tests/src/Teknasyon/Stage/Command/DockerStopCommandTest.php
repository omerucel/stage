<?php

namespace Teknasyon\Stage\Command;

class DockerStopCommandTest extends CommandTestAbstract
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
                    'rmi',
                    $build->getGeneratedId()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerStopCommand($build, $commandExecutor))->run();
    }
}
