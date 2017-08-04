<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Suite\DockerComposeSuite;
use Teknasyon\Stage\Suite\DockerfileSuite;
use Teknasyon\Stage\Suite\DockerImageSuite;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerImageSuiteSetting;

class SuiteFactoryTest extends TestCase
{
    public function testFactoryDockerfile()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new DockerfileSuiteSetting('suitename', []);
        $suite = SuiteFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(DockerfileSuite::class, $suite);
    }

    public function testFactoryDockerCompose()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new DockerComposeSuiteSetting('suitename', []);
        $suite = SuiteFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(DockerComposeSuite::class, $suite);
    }

    public function testFactoryDockerImage()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new DockerImageSuiteSetting('suitename', []);
        $suite = SuiteFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(DockerImageSuite::class, $suite);
    }
}
