<?php

namespace Teknasyon\Stage\Factory;

use DI\Container;
use DI\ContainerBuilder;

class ContainerFactory
{
    /**
     * @return Container
     */
    public static function factory()
    {
        $builder = new ContainerBuilder();
        return $builder->build();
    }
}

