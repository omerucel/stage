<?php

namespace Teknasyon\Stage;

use Symfony\Component\Yaml\Yaml;

class SuiteSettingParser
{
    public static function parse($yamlFile)
    {
        $sourceCodeDir = dirname($yamlFile);
        $projectSettings = Yaml::parse(file_get_contents($yamlFile));
        $defaultSuiteSettings = [];
        if (isset($projectSettings['default'])) {
            $defaultSuiteSettings = $projectSettings['default'];
            unset($projectSettings['default']);
        }
        $suiteSettings = [];
        foreach ($projectSettings as $suiteName => $suiteSetting) {
            $suiteSetting['source_code_dir'] = $sourceCodeDir;
            $suiteSetting = array_merge($defaultSuiteSettings, $suiteSetting);
            $suiteSettings[$suiteName] = SuiteSettingFactory::factory($suiteName, $suiteSetting);
        }
        return $suiteSettings;
    }
}
