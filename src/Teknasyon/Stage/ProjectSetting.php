<?php

namespace Teknasyon\Stage;

use Symfony\Component\Yaml\Yaml;

class ProjectSetting
{
    public $dockerComposeFile;
    public $serviceName;
    public $command;
    public $sourceCodeDir;
    public $outputDir;

    /**
     * @param array $settings
     */
    private function __construct(array $settings = [])
    {
        $this->dockerComposeFile = $settings['docker_compose_file'] ?? null;
        $this->serviceName = $settings['service_name'] ?? null;
        $this->command = $settings['command'] ?? null;
        $this->outputDir = $settings['output_dir'] ?? null;
    }

    /**
     * @param $yamlFile
     * @return ProjectSetting
     */
    public static function loadYaml($yamlFile)
    {
        $projectSetting = new ProjectSetting(Yaml::parse(file_get_contents($yamlFile)));
        $projectSetting->sourceCodeDir = dirname($yamlFile);
        return $projectSetting;
    }
}
