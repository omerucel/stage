<?php

namespace Teknasyon\Stage\Command;

class DockerBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerfileSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    '/usr/local/bin/docker',
                    'build',
                    '-f',
                    $suite->getBuildDir() . '/Dockerfile',
                    '-t',
                    $suite->getGeneratedId(),
                    $suite->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerBuildCommand($commandExecutor))->run($suite);
    }
}
