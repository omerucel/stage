<?php

namespace Teknasyon\Stage;

use Symfony\Component\Yaml\Yaml;

class EnvironmentSettingParser
{
    /**
     * @param $yamlFile
     * @return EnvironmentSetting
     */
    public static function parse($yamlFile)
    {
        return new EnvironmentSetting(Yaml::parse(file_get_contents($yamlFile)));
    }
}
