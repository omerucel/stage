<?php

namespace Teknasyon\Stage\Factory;

use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Notification\CompositeSender;
use Teknasyon\Stage\Notification\Slack;

class NotificationSenderFactory
{
    public static function factory(ContainerInterface $container)
    {
        $sender = new CompositeSender();
        $sender->addSender($container->get(Slack\CompositeSender::class));
        return $sender;
    }
}
