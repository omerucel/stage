<?php

namespace Teknasyon\Stage\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Teknasyon\Stage\Build;
use Teknasyon\Stage\CommandExecutor;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\ProjectSetting;

abstract class CommandTestAbstract extends TestCase
{
    /**
     * @var Build
     */
    protected $build;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $commandExecutor;

    protected function setUp()
    {
        $projectSetting = new ProjectSetting(
            '/sourcecode',
            [
                'suitename' => [
                    'type' => 'DockerCompose',
                    'docker_compose_file' => 'docker-compose.yml',
                    'service_name' => 'app',
                    'command' => 'sh /data/project/test.sh',
                    'output_dir' => 'tmp/output'
                ]
            ]
        );
        $this->build = new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['suitename']);
        $this->commandExecutor = $this->getMockBuilder(CommandExecutor::class)->getMock();
    }

    /**
     * @param $exitCode
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function generateProcessWithExitCode($exitCode)
    {
        $process = $this->getMockBuilder(Process::class)
            ->disableOriginalConstructor()
            ->getMock();
        $process->expects($this->any())
            ->method('getExitCode')
            ->willReturn($exitCode);
        return $process;
    }

    /**
     * @return EnvironmentSetting
     */
    protected function getEnvironmentSetting()
    {
        return new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs',
            'docker_compose_bin' => '/usr/local/bin/docker-compose',
            'docker_bin' => '/usr/local/bin/docker'
        ]);
    }
}
