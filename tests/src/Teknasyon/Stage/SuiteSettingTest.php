<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class SuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $settings = [
            'docker_compose_file' => 'docker/docker-compose.yml',
            'service_name' => 'app',
            'output_dir' => 'tmp/output',
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = new SuiteSetting('default', $settings);
        $this->assertEquals('default', $setting->name);
        $this->assertEquals($settings['docker_compose_file'], $setting->dockerComposeFile);
        $this->assertEquals($settings['service_name'], $setting->serviceName);
        $this->assertEquals($settings['output_dir'], $setting->outputDir);
        $this->assertEquals($settings['command'], $setting->command);
    }
}
