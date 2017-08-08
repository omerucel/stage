<?php

namespace Teknasyon\Stage\Command;

class DockerBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerfileJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'build',
                    '-f',
                    $job->getBuildDir() . '/Dockerfile',
                    '-t',
                    $job->getGeneratedId(),
                    $job->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerBuildCommand($commandExecutor))->run($job);
    }
}
