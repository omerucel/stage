<?php

namespace Teknasyon\Stage\Command;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;
use Teknasyon\Stage\CommandExecutor;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\Job\DockerComposeJob;
use Teknasyon\Stage\Job\DockerfileJob;
use Teknasyon\Stage\Job\DockerImageJob;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerImageSuiteSetting;

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
     * @return DockerComposeJob
     */
    protected function getDockerComposeJob()
    {
        $suiteSetting = new DockerComposeSuiteSetting('suitename', [
            'type' => 'DockerCompose',
            'docker_compose_file' => 'docker-compose.yml',
            'source_code_dir' => '/sourcecode',
            'service_name' => 'app',
            'command' => 'sh /data/project/test.sh',
            'output_dir' => ['tmp/output', 'logs']
        ]);
        return new DockerComposeJob($this->getContainer(), $suiteSetting);
    }

    /**
     * @return DockerfileJob
     */
    protected function getDockerfileJob()
    {
        $suiteSetting = new DockerfileSuiteSetting('suitename', [
            'type' => 'Dockerfile',
            'dockerfile' => 'Dockerfile',
            'source_code_dir' => '/sourcecode',
            'source_code_target' => '/app',
            'command' => 'sh /app/test.sh',
            'output_dir' => ['tmp/output', 'logs']
        ]);
        return new DockerfileJob($this->getContainer(), $suiteSetting);
    }

    /**
     * @return DockerImageJob
     */
    protected function getDockerImageJob()
    {
        $suiteSetting = new DockerImageSuiteSetting('suitename', [
            'type' => 'Dockerfile',
            'dockerimage' => 'imagename',
            'source_code_dir' => '/sourcecode',
            'source_code_target' => '/app',
            'command' => 'sh /app/test.sh',
            'output_dir' => ['tmp/output', 'logs']
        ]);
        return new DockerImageJob($this->getContainer(), $suiteSetting);
    }

    /**
     * @return \DI\Container
     */
    protected function getContainer()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs',
            'docker_compose_bin' => '/usr/local/bin/docker-compose',
            'docker_bin' => '/usr/local/bin/docker'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        return $container;
    }
}
