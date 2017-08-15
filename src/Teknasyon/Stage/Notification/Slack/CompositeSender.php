<?php

namespace Teknasyon\Stage\Notification\Slack;

use Psr\Container\ContainerInterface;

class CompositeSender extends \Teknasyon\Stage\Notification\CompositeSender
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->addSender($container->get(JobStartedSender::class));
        $this->addSender($container->get(JobCompletedSender::class));
    }
}
