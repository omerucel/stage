<?php

namespace Teknasyon\Stage\Command;

class DockerStopCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $job = $this->getDockerComposeJob();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($job) {
                $expected = [
                    '/usr/local/bin/docker',
                    'rmi',
                    $job->getGeneratedId()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerStopCommand($commandExecutor))->run($job);
    }
}
