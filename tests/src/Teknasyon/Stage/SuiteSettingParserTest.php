<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;

class SuiteSettingParserTest extends TestCase
{
    public function testParse()
    {
        $suiteSettings = SuiteSettingParser::parse(realpath(__DIR__) . '/stage.yml');
        $this->assertCount(2, $suiteSettings);
        $this->assertInstanceOf(DockerfileSuiteSetting::class, $suiteSettings['dockerfile']);
        $this->assertInstanceOf(DockerComposeSuiteSetting::class, $suiteSettings['dockercompose']);
    }

    public function testMergeDefaultSuiteSettings()
    {
        $suiteSettings = SuiteSettingParser::parse(realpath(__DIR__) . '/stage.yml');
        $this->assertEquals(['var/output'], $suiteSettings['dockerfile']->outputDir);
        $this->assertEquals(['var/output'], $suiteSettings['dockercompose']->outputDir);
    }
}
