<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Build;
use Teknasyon\Stage\ProjectSetting;

class DockerRunCommandTest extends CommandTestAbstract
{
    public function testRun()
    {
        $projectSetting = new ProjectSetting(
            '/sourcecode',
            [
                'suitename' => [
                    'dockerfile' => 'Dockerfile',
                    'source_code_target' => '/app',
                    'command' => 'sh /app/test.sh',
                    'output_dir' => 'tmp/output'
                ]
            ]
        );
        $build = new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['suitename']);
        $this->commandExecutor->expects($this->at(0))
            ->method('execute')
            ->willReturnCallback(function ($args) use ($build) {
                $expected = [
                    '/usr/local/bin/docker',
                    'run',
                    '--rm',
                    '--name',
                    $build->getGeneratedId(),
                    '-v',
                    $build->getBuildDir() . ':/app',
                    $build->getGeneratedId(),
                    'sh /app/test.sh'
                ];
                $this->assertEquals($expected, $args);
            });
        $command = new DockerRunCommand($build, $this->commandExecutor);
        $command->run();
    }
}
