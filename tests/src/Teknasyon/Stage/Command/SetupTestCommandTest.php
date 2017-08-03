<?php

namespace Teknasyon\Stage\Command;

class SetupTestCommandTest extends CommandTestAbstract
{
    /**
     * @var SetupTestCommand
     */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->command = new SetupTestCommand($this->build, $this->commandExecutor);
    }

    public function testRun()
    {
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                $expected = [
                    'cp',
                    '-r',
                    '/sourcecode',
                    $this->build->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $this->commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                $expected = [
                    'mkdir',
                    '-p',
                    $this->build->getBuildDir() . '/tmp/output'
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
            ->willReturnCallback(function () {
                return $this->generateProcessWithExitCode(-1);
            });
        $this->expectException(\Exception::class);
        $this->command->run();
    }
}
