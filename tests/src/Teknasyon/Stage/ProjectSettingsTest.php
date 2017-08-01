<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class ProjectSettingsTest extends TestCase
{
    public function testLoadYml()
    {
        $yamlFile = realpath(__DIR__) . '/stage.yml';
        $projectSetting = ProjectSetting::loadYaml($yamlFile);
        $this->assertEquals($projectSetting->dockerComposeFile, 'docker/docker-compose.yml');
        $this->assertEquals($projectSetting->serviceName, 'app');
        $this->assertEquals($projectSetting->command, 'sh /data/project/test.sh');
        $this->assertEquals($projectSetting->sourceCodeDir, dirname($yamlFile));
        $this->assertEquals($projectSetting->outputDir, 'tmp/output');
    }
}
