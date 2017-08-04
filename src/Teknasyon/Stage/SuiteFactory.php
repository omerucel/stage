<?php

namespace Teknasyon\Stage;

use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Suite\Suite;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;

class SuiteFactory
{
    /**
     * @param ContainerInterface $container
     * @param SuiteSetting $suiteSetting
     * @return Suite
     */
    public static function factory(ContainerInterface $container, SuiteSetting $suiteSetting)
    {
        $suiteSettingClassName = get_class($suiteSetting);
        $className = str_replace('SuiteSetting', 'Suite', $suiteSettingClassName);
        return new $className($container, $suiteSetting);
    }
}
