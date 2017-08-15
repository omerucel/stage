<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\Command;

class DockerfileJobTest extends TestCase
{
    public function testGetCommands()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $suiteSetting = new DockerfileSuiteSetting('suitename', []);
        $job = new DockerfileJob($container, $suiteSetting);
        $expected = [
            Command\SetupBuildCommand::class,
            Command\DockerBuildCommand::class,
            Command\DockerRunCommand::class,
            Command\DockerStopCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $job->getCommands());
    }
}
