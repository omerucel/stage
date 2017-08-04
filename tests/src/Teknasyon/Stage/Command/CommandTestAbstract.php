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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getCommandExecutor()
    {
        return $this->getMockBuilder(CommandExecutor::class)->getMock();
    }

    /**
     * @return Build
     */
    protected function getDockerComposeBuild()
    {
        $projectSetting = $this->getProjectSetting();
        return new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['dockercompose']);
    }

    /**
     * @return Build
     */
    protected function getDockerfileBuild()
    {
        $projectSetting = $this->getProjectSetting();
        return new Build($this->getEnvironmentSetting(), $projectSetting, $projectSetting->suites['dockerfile']);
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

    /**
     * @return ProjectSetting
     */
    protected function getProjectSetting()
    {
        return new ProjectSetting(
            '/sourcecode',
            [
                'dockercompose' => [
                    'type' => 'DockerCompose',
                    'docker_compose_file' => 'docker-compose.yml',
                    'service_name' => 'app',
                    'command' => 'sh /data/project/test.sh',
                    'output_dir' => ['tmp/output', 'logs']
                ],
                'dockerfile' => [
                    'type' => 'Dockerfile',
                    'dockerfile' => 'Dockerfile',
                    'source_code_target' => '/app',
                    'command' => 'sh /app/test.sh',
                    'output_dir' => ['tmp/output', 'logs']
                ],
            ]
        );
    }
}
