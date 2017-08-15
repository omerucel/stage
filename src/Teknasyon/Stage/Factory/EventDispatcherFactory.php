<?php

namespace Teknasyon\Stage\Factory;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknasyon\Stage\Event\Subscriber\BuildLogSubscriber;
use Teknasyon\Stage\Event\Subscriber\NotificationSubscriber;

class EventDispatcherFactory
{
    /**
     * @param ContainerInterface $container
     * @return EventDispatcher
     */
    public static function factory(ContainerInterface $container)
    {
        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($container->get(BuildLogSubscriber::class));
        $eventDispatcher->addSubscriber($container->get(NotificationSubscriber::class));
        return $eventDispatcher;
    }
}
