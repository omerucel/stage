<?php

namespace Teknasyon\Stage\Command;

class MoveOutputCommandTest extends CommandTestAbstract
{
    /**
     * @var MoveOutputCommand
     */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->command = new MoveOutputCommand($this->build, $this->commandExecutor);
    }

    public function testRun()
    {
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                $expected = [
                    'cp',
                    '-r',
                    $this->build->buildDir . '/' . $this->build->projectSetting->outputDir,
                    $this->build->outputDir
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
