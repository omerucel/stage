<?php

namespace Teknasyon\Stage\Suite;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\SuiteSetting;

class DockerfileSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'type' => 'Dockerfile',
            'dockerfile' => 'docker/Dockerfile',
            'source_code_target' => '/app',
            'output_dir' => 'tmp/output',
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = SuiteSetting::factory($suiteName, $settings);
        $this->assertInstanceOf(DockerfileSuiteSetting::class, $setting);
        /**
         * @var DockerfileSuiteSetting $setting
         */
        $this->assertObjectHasAttribute('dockerfile', $setting);
        $this->assertObjectHasAttribute('sourceCodeTarget', $setting);
        $this->assertNotNull($setting->dockerfile);
        $this->assertNotNull($setting->sourceCodeTarget);
        $this->assertEquals($settings['dockerfile'], $setting->dockerfile);
        $this->assertEquals($settings['source_code_target'], $setting->sourceCodeTarget);
    }
}
