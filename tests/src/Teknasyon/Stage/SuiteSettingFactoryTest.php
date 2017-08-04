<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;

class SuiteSettingFactoryTest extends TestCase
{
    public function testDockerfileSuiteSetting()
    {
        $name = 'dockerfile';
        $suiteSettings = ['type' => 'Dockerfile'];
        $suiteSetting = SuiteSettingFactory::factory($name, $suiteSettings);
        $this->assertInstanceOf(DockerfileSuiteSetting::class, $suiteSetting);
    }

    public function testDockerComposeSuiteSetting()
    {
        $name = 'dockercompose';
        $suiteSettings = ['type' => 'DockerCompose'];
        $suiteSetting = SuiteSettingFactory::factory($name, $suiteSettings);
        $this->assertInstanceOf(DockerComposeSuiteSetting::class, $suiteSetting);
    }
}
