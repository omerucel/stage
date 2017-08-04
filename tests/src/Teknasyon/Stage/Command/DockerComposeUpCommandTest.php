<?php

namespace Teknasyon\Stage\Command;

class DockerComposeUpCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args) use ($suite) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $suite->getGeneratedId(),
                    '-f',
                    $suite->getBuildDir() . '/docker-compose.yml',
                    'up',
                    '-d',
                    '--build'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        (new DockerComposeUpCommand($commandExecutor))->run($suite);
    }

    public function testExitCode()
    {
        $suite = $this->getDockerComposeSuite();
        $commandExecutor = $this->getCommandExecutor();
        $commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        (new DockerComposeUpCommand($commandExecutor))->run($suite);
    }
}
