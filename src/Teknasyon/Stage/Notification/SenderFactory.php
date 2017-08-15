<?php

namespace Teknasyon\Stage\Notification;

use DI\Container;

class SenderFactory
{
    /**
     * @param Container $container
     * @param $clientType
     * @return Sender
     */
    public static function factory(Container $container, $clientType)
    {
        $className = 'Teknasyon\Stage\Notification\\' . ucwords($clientType) . '\CompositeSender';
        return $container->get($className);
    }
}
