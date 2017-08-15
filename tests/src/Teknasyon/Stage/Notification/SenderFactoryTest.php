<?php

namespace Teknasyon\Stage\Notification;

use DI\Container;
use PHPUnit\Framework\TestCase;

class SenderFactoryTest extends TestCase
{
    public function testFactory()
    {
        $clientType = 'slack';
        $container = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $container->expects($this->at(0))
            ->method('get')
            ->willReturnCallback(function ($className) {
                $this->assertEquals(Slack\CompositeSender::class, $className);
            });
        SenderFactory::factory($container, $clientType);
    }
}
