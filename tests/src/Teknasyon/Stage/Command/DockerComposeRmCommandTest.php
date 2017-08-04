<?php

namespace Teknasyon\Stage\Command;

class DockerComposeRmCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $suite->getGeneratedId(),
                    '-f',
                    $suite->getBuildDir() . '/docker-compose.yml',
                    'rm',
                    '--force',
                    '--stop'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new DockerComposeRmCommand($commandExecutor))->run($suite);
    }

    public function testExitCode()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new DockerComposeRmCommand($commandExecutor))->run($suite);
    }
}
