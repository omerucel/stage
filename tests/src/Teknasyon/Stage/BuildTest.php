<?php

namespace Teknasyon\Stage;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    /**
     * @var Build
     */
    protected $build;

    protected function setUp()
    {
        $settings = [
            'builds_dir' => '/builds',
            'output_dir' => '/outputs',
            'docker_compose_bin' => '/usr/local/bin/docker-compose',
            'docker_bin' => '/usr/local/bin/docker'
        ];
        $environmentSettings = new EnvironmentSetting($settings);
        $projectSettings = new ProjectSetting(
            '/sourcecode',
            [
                'suitename' => [
                    'type' => 'DockerCompose',
                    'docker_compose_file' => 'docker-compose.yml',
                    'service_name' => 'app',
                    'output_dir' => 'tmp/output',
                    'command' => 'sh /data/project/test.sh'
                ]
            ]
        );
        $this->build = new Build($environmentSettings, $projectSettings, $projectSettings->suites['suitename']);
    }

    public function testProperties()
    {
        $this->assertInstanceOf(EnvironmentSetting::class, $this->build->environmentSetting);
        $this->assertInstanceOf(ProjectSetting::class, $this->build->projectSetting);
        $this->assertInstanceOf(SuiteSetting::class, $this->build->suiteSetting);
    }

    public function testGetGeneratedId()
    {
        $this->assertEquals(32, strlen($this->build->getGeneratedId()));
    }

    public function testGetBuildDir()
    {
        $this->assertEquals('/builds/' . $this->build->getGeneratedId(), $this->build->getBuildDir());
    }

    public function testGetOutputDir()
    {
        $this->assertEquals('/outputs/' . $this->build->getGeneratedId(), $this->build->getOutputDir());
    }
}
