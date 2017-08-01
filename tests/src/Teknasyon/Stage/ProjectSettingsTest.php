<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class ProjectSettingsTest extends TestCase
{
    public function testLoadYml()
    {
        $yamlFile = realpath(__DIR__) . '/stage.yml';
        $projectSetting = ProjectSetting::loadYaml($yamlFile);
        $this->assertEquals($projectSetting->sourceCodeDir, dirname($yamlFile));
        $this->assertCount(2, $projectSetting->suites);
        $this->assertEquals($projectSetting->suites['default']->name, 'default');
        $this->assertEquals($projectSetting->suites['default']->dockerComposeFile, 'docker/docker-compose.yml');
        $this->assertEquals($projectSetting->suites['default']->serviceName, 'app');
        $this->assertEquals($projectSetting->suites['default']->command, 'sh /data/project/test.sh');
        $this->assertEquals($projectSetting->suites['default']->outputDir, 'tmp/output');
        $this->assertEquals($projectSetting->suites['php7']->name, 'php7');
        $this->assertEquals($projectSetting->suites['php7']->dockerComposeFile, 'docker/docker-compose.php7.yml');
        $this->assertEquals($projectSetting->suites['php7']->serviceName, 'app');
        $this->assertEquals($projectSetting->suites['php7']->command, 'sh /data/project/test.sh');
        $this->assertEquals($projectSetting->suites['php7']->outputDir, 'tmp/output');
    }
}
