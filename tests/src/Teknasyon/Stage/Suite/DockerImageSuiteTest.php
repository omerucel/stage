<?php

namespace Teknasyon\Stage\Suite;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerImageSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;
use Teknasyon\Stage\Command;

class DockerImageSuiteTest extends TestCase
{
    /**
     * @var DockerImageSuite
     */
    protected $suite;

    protected function setUp()
    {
        $environmentSetting = new EnvironmentSetting([
            'builds_dir' => '/builds',
            'output_dir' => '/outputs'
        ]);
        $container = ContainerBuilder::buildDevContainer();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $suiteSetting = $this->getMockBuilder(DockerImageSuiteSetting::class)->disableOriginalConstructor()->getMock();
        $this->suite = new DockerImageSuite($container, $suiteSetting);
    }

    public function testParameters()
    {
        $this->assertInstanceOf(SuiteSettingAbstract::class, $this->suite->suiteSetting);
    }

    public function testGetGeneratedId()
    {
        $this->assertEquals(32, strlen($this->suite->getGeneratedId()));
    }

    public function testGetBuildDir()
    {
        $this->assertEquals('/builds/' . $this->suite->getGeneratedId(), $this->suite->getBuildDir());
    }

    public function testGetOutputDir()
    {
        $this->assertEquals('/outputs/' . $this->suite->getGeneratedId(), $this->suite->getOutputDir());
    }

    public function testGetCommands()
    {
        $expected = [
            Command\SetupBuildCommand::class,
            Command\DockerRunImageCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $this->suite->getCommands());
    }
}
