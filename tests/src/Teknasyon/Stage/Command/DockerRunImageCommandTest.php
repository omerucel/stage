<?php

namespace Teknasyon\Stage\Command;

class DockerRunImageCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerImageSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    '/usr/local/bin/docker',
                    'run',
                    '--rm',
                    '--name',
                    $suite->getGeneratedId(),
                    '-v',
                    $suite->getBuildDir() . ':/app',
                    $suite->suiteSetting->dockerimage,
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunImageCommand($commandExecutor))->run($suite);
    }
}
