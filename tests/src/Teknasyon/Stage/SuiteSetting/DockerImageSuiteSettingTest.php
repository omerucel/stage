<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerImageSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'type' => 'DockerImage',
            'dockerimage' => 'php:7.1-apache',
            'source_code_dir' => '/sourcecode',
            'source_code_target' => '/var/www/html',
            'output_dir' => ['tmp/output'],
            'command' => 'sh /var/www/html/test.sh'
        ];
        $setting = new DockerImageSuiteSetting($suiteName, $settings);
        $this->assertEquals('php:7.1-apache', $setting->dockerimage);
        $this->assertEquals('/sourcecode', $setting->sourceCodeDir);
        $this->assertEquals('/var/www/html', $setting->sourceCodeTarget);
        $this->assertEquals(['tmp/output'], $setting->outputDir);
        $this->assertEquals('sh /var/www/html/test.sh', $setting->command);
    }
}
