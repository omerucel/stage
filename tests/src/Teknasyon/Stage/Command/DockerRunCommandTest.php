<?php

namespace Teknasyon\Stage\Command;

class DockerRunCommandTest extends CommandTestAbstract
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
                    'run',
                    '--rm',
                    '--name',
                    $job->getGeneratedId(),
                    '-v',
                    $job->getBuildDir() . ':/app',
                    $job->getGeneratedId(),
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunCommand($commandExecutor))->run($job);
    }
}
