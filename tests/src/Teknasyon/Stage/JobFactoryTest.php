<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Job;
use Teknasyon\Stage\SuiteSetting;

class JobFactoryTest extends TestCase
{
    public function testDockerfileJob()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new SuiteSetting\DockerfileSuiteSetting('suitename', []);
        $suite = JobFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(Job\DockerfileJob::class, $suite);
    }

    public function testDockerComposeJob()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new SuiteSetting\DockerComposeSuiteSetting('suitename', []);
        $suite = JobFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(Job\DockerComposeJob::class, $suite);
    }

    public function testDockerImageJob()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $suiteSetting = new SuiteSetting\DockerImageSuiteSetting('suitename', []);
        $suite = JobFactory::factory($container, $suiteSetting);
        $this->assertInstanceOf(Job\DockerImageJob::class, $suite);
    }
}
