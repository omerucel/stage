<?php

namespace Teknasyon\Stage\Command;

class StartServicesCommandTest extends CommandTestAbstract
{
    /**
     * @var StartServicesCommand
     */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->command = new StartServicesCommand($this->build, $this->commandExecutor);
    }

    public function testRun()
    {
        $this->commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function ($args) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $this->build->id,
                    '-f',
                    $this->build->dockerComposeFile,
                    'up',
                    '-d',
                    '--build'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $this->command->run();
    }

    public function testExitCode()
    {
        $this->commandExecutor->expects($this->any())
            ->method('execute')
            ->withAnyParameters()
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        $this->command->run();
    }
}
