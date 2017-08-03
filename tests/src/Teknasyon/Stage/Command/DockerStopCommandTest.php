<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Build;
use Teknasyon\Stage\ProjectSetting;

class DockerStopCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $projectSetting = new ProjectSetting(
            '/sourcecode',
            [
                'default' => [
                    'dockerfile' => 'Dockerfile',
                    'source_code_target' => '/app',
                    'command' => 'sh /app/test.sh',
                    'output_dir' => 'tmp/output'
                ]
            ]
        );
        $build = new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['default']);
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker',
                    'rmi',
                    $build->getGeneratedId()
                ];
                $this->assertEquals($expected, $args);
            });
        $command = new DockerStopCommand($build, $this->commandExecutor);
        $command->run();
    }
}
