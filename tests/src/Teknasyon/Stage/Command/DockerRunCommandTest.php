<?php

namespace Teknasyon\Stage\Command;

class DockerRunCommandTest extends CommandTestAbstract
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
                    'run',
                    '--rm',
                    '--name',
                    $suite->getGeneratedId(),
                    '-v',
                    $suite->getBuildDir() . ':/app',
                    $suite->getGeneratedId(),
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerRunCommand($commandExecutor))->run($suite);
    }
}
