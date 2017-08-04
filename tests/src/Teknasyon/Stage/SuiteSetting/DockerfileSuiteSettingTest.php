<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerfileSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'type' => 'Dockerfile',
            'dockerfile' => 'docker/Dockerfile',
            'source_code_dir' => '/sourcecode',
            'source_code_target' => '/app',
            'output_dir' => ['tmp/output'],
            'command' => 'sh /data/project/test.sh'
        ];
        $setting = new DockerfileSuiteSetting($suiteName, $settings);
        $this->assertEquals('docker/Dockerfile', $setting->dockerfile);
        $this->assertEquals('/sourcecode', $setting->sourceCodeDir);
        $this->assertEquals('/app', $setting->sourceCodeTarget);
        $this->assertEquals(['tmp/output'], $setting->outputDir);
        $this->assertEquals('sh /data/project/test.sh', $setting->command);
    }
}
