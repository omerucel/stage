<?php

namespace Teknasyon\Stage;

use Symfony\Component\Yaml\Yaml;

class ProjectSetting
{
    public $sourceCodeDir;
    public $suites = [];

    /**
     * @param array $settings
     */
    private function __construct(array $settings = [])
    {
        $suiteNames = array_keys($settings);
        $defaultSuiteSettings = [];
        if (isset($settings['default'])) {
            $defaultSuiteSettings = $settings['default'];
        }
        foreach ($suiteNames as $name) {
            $this->suites[$name] = new SuiteSetting($name, array_merge($defaultSuiteSettings, $settings[$name]));
        }
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
