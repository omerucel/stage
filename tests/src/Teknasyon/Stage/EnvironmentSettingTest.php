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
            'output_dir' => '/data/outputs',
            'notification' => [
                'slack' => [
                    'webhook_url' => 'http://slack.com'
                ]
            ]
        ];
        $environmentSetting = new EnvironmentSetting($settings);
        $this->assertEquals($settings['docker_compose_bin'], $environmentSetting->dockerComposeBin);
        $this->assertEquals($settings['docker_bin'], $environmentSetting->dockerBin);
        $this->assertEquals($settings['builds_dir'], $environmentSetting->buildsDir);
        $this->assertEquals($settings['output_dir'], $environmentSetting->outputDir);
        $this->assertEquals($settings['notification'], $environmentSetting->notification);
    }
}
