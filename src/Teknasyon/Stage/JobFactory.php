<?php

namespace Teknasyon\Stage;

use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Job\Job;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;

class JobFactory
{
    /**
     * @param ContainerInterface $container
     * @param SuiteSetting $suiteSetting
     * @return Job
     */
    public static function factory(ContainerInterface $container, SuiteSetting $suiteSetting)
    {
        $suiteSettingClassName = get_class($suiteSetting);
        $className = str_replace('SuiteSetting', 'Job', $suiteSettingClassName);
        return new $className($container, $suiteSetting);
    }
}
