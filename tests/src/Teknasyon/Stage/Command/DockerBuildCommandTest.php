<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Build;
use Teknasyon\Stage\CommandExecutor;
use Teknasyon\Stage\ProjectSetting;

class DockerBuildCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $projectSetting = new ProjectSetting(
            '/sourcecode',
            [
                'default' => [
                    'dockerfile' => 'Dockerfile',
                    'command' => 'sh /data/project/test.sh',
                    'output_dir' => 'tmp/output'
                ]
            ]
        );
        $build = new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['default']);
        $commandExecutor = $this->getMockBuilder(CommandExecutor::class)->getMock();
        $commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker',
                    'build',
                    '-f',
                    $build->getBuildDir() . '/Dockerfile',
                    '-t',
                    $build->getGeneratedId(),
                    $build->getBuildDir()
                ];
                $this->assertEquals($expected, $args);
            });
        $command = new DockerBuildCommand($build, $commandExecutor);
        $command->run();
    }
}
