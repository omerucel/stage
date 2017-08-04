<?php

namespace Teknasyon\Stage;

use Symfony\Component\Yaml\Yaml;

class ProjectSetting
{
    public $sourceCodeDir;
    public $suites = [];

    /**
     * @param $sourceCodeDir
     * @param array $settings
     */
    public function __construct($sourceCodeDir, array $settings = [])
    {
        $this->sourceCodeDir = $sourceCodeDir;
        $defaultSuiteSettings = [];
        if (isset($settings['default'])) {
            $defaultSuiteSettings = $settings['default'];
            unset($settings['default']);
        }
        foreach (array_keys($settings) as $name) {
            $this->suites[$name] = SuiteSetting::factory($name, array_merge($defaultSuiteSettings, $settings[$name]));
        }
    }

    /**
     * @param $yamlFile
     * @return ProjectSetting
     */
    public static function loadYaml($yamlFile)
    {
        return new ProjectSetting(dirname($yamlFile), Yaml::parse(file_get_contents($yamlFile)));
    }
}
