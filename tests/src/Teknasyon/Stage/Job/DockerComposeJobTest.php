<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Command;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;

class DockerComposeJobTest extends TestCase
{
    /**
     * @var DockerComposeJob
     */
    protected $job;

    protected function setUp()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $suiteSetting = $this->getMockBuilder(DockerComposeSuiteSetting::class)->disableOriginalConstructor()->getMock();
        $this->job = new DockerComposeJob($container, $suiteSetting);
    }

    public function testParameters()
    {
        $this->assertInstanceOf(SuiteSettingAbstract::class, $this->job->suiteSetting);
    }

    public function testGetGeneratedId()
    {
        $this->assertEquals(32, strlen($this->job->getGeneratedId()));
    }

    public function testGetBuildDir()
    {
        $this->assertEquals('/builds/' . $this->job->getGeneratedId(), $this->job->getBuildDir());
    }

    public function testGetOutputDir()
    {
        $this->assertEquals('/outputs/' . $this->job->getGeneratedId(), $this->job->getOutputDir());
    }

    public function testGetCommands()
    {
        $expected = [
            Command\SetupBuildCommand::class,
            Command\DockerComposeUpCommand::class,
            Command\DockerComposeRunCommand::class,
            Command\DockerComposeRmCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $this->job->getCommands());
    }
}
