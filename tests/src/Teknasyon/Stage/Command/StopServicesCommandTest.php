<?php

namespace Teknasyon\Stage\Command;

class StopServicesCommandTest extends CommandTestAbstract
{
    /**
     * @var MoveOutputCommand
     */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->command = new StopServicesCommand($this->build, $this->commandExecutor);
    }

    public function testRun()
    {
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                $expected = [
                    '/usr/local/bin/docker-compose',
                    '-p',
                    $this->build->id,
                    '-f',
                    $this->build->dockerComposeFile,
                    'rm',
                    '--force',
                    '--stop'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $this->command->run();
    }

    public function testExitCode()
    {
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        $this->command->run();
    }
}
