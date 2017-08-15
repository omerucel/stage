<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class EnvironmentSettingParserTest extends TestCase
{
    public function testParse()
    {
        $environmentSetting = EnvironmentSettingParser::parse(realpath(__DIR__) . '/environment.yml');
        $this->assertInstanceOf(EnvironmentSetting::class, $environmentSetting);
        $this->assertEquals('/usr/local/bin/docker-compose', $environmentSetting->dockerComposeBin);
        $this->assertEquals('/usr/local/bin/docker', $environmentSetting->dockerBin);
        $this->assertEquals('/outputs', $environmentSetting->outputDir);
        $this->assertEquals('/builds', $environmentSetting->buildsDir);
        $this->assertEquals(['slack' => ['webhook_url' => 'http://slack.com']], $environmentSetting->notification);
    }
}
