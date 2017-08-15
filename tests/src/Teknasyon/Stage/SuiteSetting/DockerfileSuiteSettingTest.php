<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerfileSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'dockerfile' => 'docker/Dockerfile',
            'source_code_target' => '/app'
        ];
        $setting = new DockerfileSuiteSetting($suiteName, $settings);
        $this->assertEquals('docker/Dockerfile', $setting->dockerfile);
        $this->assertEquals('/app', $setting->sourceCodeTarget);
    }
}
