<?php

namespace Teknasyon\Stage\Notification;

use PHPUnit\Framework\TestCase;

class CompositeSenderTest extends TestCase
{
    public function testSend()
    {
        $notification = $this->getMockBuilder(Notification::class)->getMock();
        $sender1 = $this->getMockBuilder(Sender::class)->getMock();
        $sender1->expects($this->at(0))
            ->method('send')
            ->willReturnCallback(function ($notif) use ($notification) {
                $this->assertEquals($notification, $notif);
            });
        $sender2 = $this->getMockBuilder(Sender::class)->getMock();
        $sender2->expects($this->at(0))
            ->method('send')
            ->willReturnCallback(function ($notif) use ($notification) {
                $this->assertEquals($notification, $notif);
            });
        $compositeSender = new CompositeSender();
        $compositeSender->addSender($sender1);
        $compositeSender->addSender($sender2);
        $compositeSender->send($notification);
    }
}
