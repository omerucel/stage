<?php

namespace Teknasyon\Stage\SuiteSetting;

use PHPUnit\Framework\TestCase;

class SuiteSettingAbstractTest extends TestCase
{
    public function testParameters()
    {
        $suiteName = 'suitename';
        $settings = [
            'source_code_dir' => '/sourcecode',
            'output_dir' => ['tmp/output'],
            'command' => 'sh /data/project/test.sh',
            'notification' => [
                'slack' => [
                    'channel_name' => '#channel'
                ]
            ]
        ];
        $setting = new class($suiteName, $settings) extends SuiteSettingAbstract {};
        $this->assertEquals('/sourcecode', $setting->sourceCodeDir);
        $this->assertEquals(['tmp/output'], $setting->outputDir);
        $this->assertEquals('sh /data/project/test.sh', $setting->command);
        $this->assertEquals(['slack' => ['channel_name' => '#channel']], $setting->notificationSettings);
    }
}
