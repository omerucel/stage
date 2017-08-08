<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;
use Teknasyon\Stage\Command;

class DockerfileJobTest extends TestCase
{
    /**
     * @var DockerfileJob
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
        $suiteSetting = $this->getMockBuilder(DockerfileSuiteSetting::class)->disableOriginalConstructor()->getMock();
        $this->job = new DockerfileJob($container, $suiteSetting);
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
            Command\DockerBuildCommand::class,
            Command\DockerRunCommand::class,
            Command\DockerStopCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $this->job->getCommands());
    }
}
