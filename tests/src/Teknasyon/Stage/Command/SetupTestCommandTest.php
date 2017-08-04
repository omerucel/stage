<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Build;
use Teknasyon\Stage\ProjectSetting;

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

    public function testMultipleOutputDirSupport()
    {
        $projectSetting = new ProjectSetting(
            '/sourcecode',
            [
                'suitename' => [
                    'docker_compose_file' => 'docker-compose.yml',
                    'service_name' => 'app',
                    'command' => 'sh /data/project/test.sh',
                    'output_dir' => ['tmp/output', 'logs']
                ]
            ]
        );
        $build = new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['suitename']);
        $command = new SetupTestCommand($build, $this->commandExecutor);
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) {
                return $this->generateProcessWithExitCode(0);
            });
        $this->commandExecutor->expects($this->at(1))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/tmp/output'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $this->commandExecutor->expects($this->at(2))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    'mkdir',
                    '-p',
                    $build->getBuildDir() . '/logs'
                ];
                $this->assertEquals($expected, $args);
                return $this->generateProcessWithExitCode(0);
            });
        $command->run();
    }
}
