<?php

namespace Teknasyon\Stage\Command;

class DockerStopCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    '/usr/local/bin/docker',
                    'rmi',
                    $suite->getGeneratedId()
                ];
                $this->assertEquals($expected, $args);
            });
        (new DockerStopCommand($commandExecutor))->run($suite);
    }
}
