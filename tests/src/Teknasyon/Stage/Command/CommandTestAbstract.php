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
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs',
            'docker_compose_bin' => '/usr/local/bin/docker-compose'
        ]);
        $projectSetting = ProjectSetting::loadYaml(realpath(dirname(__DIR__)) . '/stage.yml');
        $this->build = new Build($environmentSetting, $projectSetting, $projectSetting->suites['default']);
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
}
