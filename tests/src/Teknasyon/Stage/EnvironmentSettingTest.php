<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class EnvironmentSettingTest extends TestCase
{
    public function testParameters()
    {
        $settings = [
            'docker_compose_bin' => '/usr/local/bin/docker-compose',
            'docker_bin' => '/usr/local/bin/docker',
            'builds_dir' => '/data/builds',
            'output_dir' => '/data/outputs'
        ];
        $environmentSetting = new EnvironmentSetting($settings);
        $this->assertEquals($environmentSetting->dockerComposeBin, $settings['docker_compose_bin']);
        $this->assertEquals($environmentSetting->dockerBin, $settings['docker_bin']);
        $this->assertEquals($environmentSetting->buildsDir, $settings['builds_dir']);
        $this->assertEquals($environmentSetting->outputDir, $settings['output_dir']);
    }
}
