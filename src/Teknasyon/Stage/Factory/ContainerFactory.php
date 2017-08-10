<?php

namespace Teknasyon\Stage\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\EnvironmentSettingParser;

class ContainerFactory
{
    /**
     * @param $environmentSettingFilePath
     * @return Container
     */
    public static function factory($environmentSettingFilePath)
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            EventDispatcher::class => \DI\factory([EventDispatcherFactory::class, 'factory'])
        ]);
        $container = $builder->build();
        $container->set(EnvironmentSetting::class, EnvironmentSettingParser::parse($environmentSettingFilePath));
        return $container;
    }
}

