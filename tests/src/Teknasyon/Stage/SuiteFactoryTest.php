<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Suite\Suite;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;

class SuiteFactoryTest extends TestCase
{
    public function testFactoryDockerfile()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new DockerfileSuiteSetting('suitename', []);
        $suite = SuiteFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(Suite::class, $suite);
    }

    public function testFactoryDockerCompose()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new DockerComposeSuiteSetting('suitename', []);
        $suite = SuiteFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(Suite::class, $suite);
    }
}
