<?php

namespace Teknasyon\Stage;

use Teknasyon\Stage\SuiteSetting\SuiteSettingAbstract;

class SuiteSettingFactory
{
    /**
     * @param $name
     * @param array $suiteSettings
     * @return SuiteSettingAbstract
     */
    public static function factory($name, array $suiteSettings)
    {
        $type = $suiteSettings['type'];
        $className = 'Teknasyon\Stage\SuiteSetting\\' . $type . 'SuiteSetting';
        return new $className($name, $suiteSettings);
    }
}
