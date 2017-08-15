<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerComposeSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'docker_compose_file' => 'docker/docker-compose.yml',
            'service_name' => 'app'
        ];
        $setting = new DockerComposeSuiteSetting($suiteName, $settings);
        $this->assertEquals('docker/docker-compose.yml', $setting->dockerComposeFile);
        $this->assertEquals('app', $setting->serviceName);
    }
}
