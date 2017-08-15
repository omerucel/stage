<?php

namespace Teknasyon\Stage\Job;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;

class JobAbstractTest extends TestCase
{
    /**
     * @var JobAbstract
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
        $suiteSetting = $this->getMockBuilder(SuiteSettingAbstract::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->job = new class($container, $suiteSetting) extends JobAbstract {
            public function getCommands()
            {
                return [];
            }
        };
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
}
