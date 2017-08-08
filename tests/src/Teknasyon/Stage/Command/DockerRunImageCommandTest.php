<?php

namespace Teknasyon\Stage\Command;

class DockerRunImageCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerImageJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'run',
                    '--rm',
                    '--name',
                    $job->getGeneratedId(),
                    '-v',
                    $job->getBuildDir() . ':/app',
                    $job->suiteSetting->dockerimage,
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunImageCommand($commandExecutor))->run($job);
    }
}
