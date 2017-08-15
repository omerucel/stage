<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class DockerImageSuiteSettingTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'dockerimage' => 'php:7.1-apache',
            'source_code_target' => '/var/www/html'
        ];
        $setting = new DockerImageSuiteSetting($suiteName, $settings);
        $this->assertEquals('php:7.1-apache', $setting->dockerimage);
        $this->assertEquals('/var/www/html', $setting->sourceCodeTarget);
    }
}
