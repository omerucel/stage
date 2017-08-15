<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerImageSuiteSetting;
use Teknasyon\Stage\Command;

class DockerImageJobTest extends TestCase
{
    public function testGetCommands()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $suiteSetting = new DockerImageSuiteSetting('suitename', []);
        $job = new DockerImageJob($container, $suiteSetting);
        $expected = [
            Command\SetupBuildCommand::class,
            Command\DockerRunImageCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $job->getCommands());
    }
}
