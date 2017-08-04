<?php

namespace Teknasyon\Stage\Suite;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;

class DockerfileSuiteTest extends TestCase
{
    /**
     * @var DockerfileSuite
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
        $suiteSetting = $this->getMockBuilder(DockerfileSuiteSetting::class)->disableOriginalConstructor()->getMock();
        $this->suite = new DockerfileSuite($container, $suiteSetting);
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
}