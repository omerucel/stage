<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class SuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'default';
        $settings = [
            'docker_compose_file' => 'docker/docker-compose.yml',
            'service_name' => 'app',
            'output_dir' => 'tmp/output',
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = SuiteSetting::factory($suiteName, $settings);
        $this->assertNotNull($setting->name);
        $this->assertNotNull($setting->outputDir);
        $this->assertNotNull($setting->command);
        $this->assertEquals('default', $setting->name);
        $this->assertEquals([$settings['output_dir']], $setting->outputDir);
        $this->assertEquals($settings['command'], $setting->command);
    }
}
