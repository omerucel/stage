<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Command;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;

class DockerComposeJobTest extends TestCase
{
    public function testGetCommands()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $suiteSetting = new DockerComposeSuiteSetting('suitename', []);
        $job = new DockerComposeJob($container, $suiteSetting);
        $expected = [
            Command\SetupBuildCommand::class,
            Command\DockerComposeUpCommand::class,
            Command\DockerComposeRunCommand::class,
            Command\DockerComposeRmCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $job->getCommands());
    }
}
