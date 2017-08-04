<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerComposeSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'type' => 'DockerCompose',
            'docker_compose_file' => 'docker/docker-compose.yml',
            'source_code_dir' => '/sourcecode',
            'service_name' => 'app',
            'output_dir' => ['tmp/output'],
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = new DockerComposeSuiteSetting($suiteName, $settings);
        $this->assertEquals('docker/docker-compose.yml', $setting->dockerComposeFile);
        $this->assertEquals('/sourcecode', $setting->sourceCodeDir);
        $this->assertEquals('app', $setting->serviceName);
        $this->assertEquals(['tmp/output'], $setting->outputDir);
        $this->assertEquals('sh /data/project/test.sh', $setting->command);
    }
}
