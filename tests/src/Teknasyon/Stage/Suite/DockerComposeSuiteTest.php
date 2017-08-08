<?php

namespace Teknasyon\Stage\Suite;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Command;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;

class DockerComposeSuiteTest extends TestCase
{
    /**
     * @var DockerComposeSuite
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
        $suiteSetting = $this->getMockBuilder(DockerComposeSuiteSetting::class)->disableOriginalConstructor()->getMock();
        $this->suite = new DockerComposeSuite($container, $suiteSetting);
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
            Command\DockerComposeUpCommand::class,
            Command\DockerComposeRunCommand::class,
            Command\DockerComposeRmCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
        $this->assertEquals($expected, $this->suite->getCommands());
    }
}
