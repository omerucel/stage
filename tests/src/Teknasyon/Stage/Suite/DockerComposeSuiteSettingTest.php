<?php

namespace Teknasyon\Stage\Suite;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\SuiteSetting;

class DockerComposeSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'type' => 'DockerCompose',
            'docker_compose_file' => 'docker/docker-compose.yml',
            'service_name' => 'app',
            'output_dir' => 'tmp/output',
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = SuiteSetting::factory($suiteName, $settings);
        $this->assertInstanceOf(DockerComposeSuiteSetting::class, $setting);
        /**
         * @var DockerComposeSuiteSetting $setting
         */
        $this->assertNotNull($setting->dockerComposeFile);
        $this->assertNotNull($setting->serviceName);
        $this->assertEquals($settings['docker_compose_file'], $setting->dockerComposeFile);
        $this->assertEquals($settings['service_name'], $setting->serviceName);
    }
}
