<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    public function testAutoGeneratedName()
    {
        $settings = [
            'builds_dir' => '/builds',
            'output_dir' => '/outputs',
            'docker_compose_bin' => '/usr/local/bin/docker-compose'
        ];
        $environmentSettings = new EnvironmentSetting($settings);
        $projectSettings = ProjectSetting::loadYaml(realpath(__DIR__) . '/stage.yml');
        $build = new Build($environmentSettings, $projectSettings, $projectSettings->suites['default']);
        $this->assertEquals(32, strlen($build->id));
        $this->assertEquals('/builds/' . $build->id, $build->buildDir);
        $this->assertEquals('/outputs/' . $build->id, $build->outputDir);
        $this->assertEquals('/builds/' . $build->id . '/docker/docker-compose.yml', $build->dockerComposeFile);
        $this->assertEquals('/builds', $build->environmentSetting->buildsDir);
        $this->assertEquals('/outputs', $build->environmentSetting->outputDir);
        $this->assertEquals('/usr/local/bin/docker-compose', $build->environmentSetting->dockerComposeBin);
    }
}
