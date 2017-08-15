<?php

namespace Teknasyon\Stage\Notification\Slack;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Notification\Notification;

class CompositeSenderTest extends TestCase
{
    public function testSend()
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $container->expects($this->at(0))
            ->method('get')
            ->with(JobStartedSender::class)
            ->willReturn($this->getMockBuilder(JobStartedSender::class)->disableOriginalConstructor()->getMock());
        $container->expects($this->at(1))
            ->method('get')
            ->with(JobCompletedSender::class)
            ->willReturn($this->getMockBuilder(JobCompletedSender::class)->disableOriginalConstructor()->getMock());
        $notification = $this->getMockBuilder(Notification::class)->getMock();
        $client = new CompositeSender($container);
        $client->send($notification);
    }
}
