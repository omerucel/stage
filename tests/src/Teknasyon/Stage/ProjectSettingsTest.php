<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class ProjectSettingsTest extends TestCase
{
    public function testSourceDir()
    {
        $sourceCodeDir = '/sourcecode';
        $projectSettings = [];
        $projectSetting = new ProjectSetting($sourceCodeDir, $projectSettings);
        $this->assertEquals('/sourcecode', $projectSetting->sourceCodeDir);
    }

    public function testSuites()
    {
        $sourceCodeDir = '/sourcecode';
        $projectSettings = [
            'suite1' => [
                'dockerfile' => 'Dockerfile'
            ],
            'suite2' => [
                'dockerfile' => 'Dockerfile'
            ]
        ];
        $projectSetting = new ProjectSetting($sourceCodeDir, $projectSettings);
        $this->assertEquals('/sourcecode', $projectSetting->sourceCodeDir);
        $this->assertCount(2, $projectSetting->suites);
    }

    public function testMergeDefaultSuiteSettings()
    {
        $sourceCodeDir = '/sourcecode';
        $projectSettings = [
            'default' => [
                'dockerfile' => 'Dockerfile',
                'command' => 'sh /data/project/test.sh',
                'output_dir' => 'tmp/output'
            ],
            'php7' => [
                'dockerfile' => 'Dockerfile.php7'
            ]
        ];
        $projectSetting = new ProjectSetting($sourceCodeDir, $projectSettings);
        $this->assertEquals('/sourcecode', $projectSetting->sourceCodeDir);
        $this->assertCount(2, $projectSetting->suites);
        $this->assertEquals('Dockerfile.php7', $projectSetting->suites['php7']->dockerfile);
        $this->assertEquals('sh /data/project/test.sh', $projectSetting->suites['php7']->command);
        $this->assertEquals(['tmp/output'], $projectSetting->suites['php7']->outputDir);
    }

    public function testLoadYml()
    {
        $projectSetting = ProjectSetting::loadYaml(realpath(__DIR__) . '/stage.yml');
        $this->assertEquals(realpath(__DIR__), $projectSetting->sourceCodeDir);
        $this->assertCount(2, $projectSetting->suites);
    }
}
