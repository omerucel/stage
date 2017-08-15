<?php

namespace Teknasyon\Stage\Event\Subscriber;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Event\JobCompletedEvent;
use Teknasyon\Stage\Event\JobStartedEvent;
use Teknasyon\Stage\Job\Job;
use Teknasyon\Stage\Notification\JobCompletedNotification;
use Teknasyon\Stage\Notification\JobStartedNotification;
use Teknasyon\Stage\Notification\Sender;

class NotificationSubscriberTest extends TestCase
{
    public function testSubscribedEvents()
    {
        $expected = [
            JobStartedEvent::NAME => 'onJobStarted',
            JobCompletedEvent::NAME => 'onJobCompleted'
        ];
        $this->assertEquals($expected, NotificationSubscriber::getSubscribedEvents());
    }

    public function testOnJobStarted()
    {
        $job = $this->getMockBuilder(Job::class)->disableOriginalConstructor()->getMock();
        $sender = $this->getMockBuilder(Sender::class)->getMock();
        $sender->expects($this->at(0))
            ->method('send')
            ->willReturnCallback(function ($notification) {
                $this->assertInstanceOf(JobStartedNotification::class, $notification);
            });
        $event = new JobStartedEvent($job);
        $listener = new NotificationSubscriber($sender);
        $listener->onJobStarted($event);
    }

    public function testOnJobCompleted()
    {
        $job = $this->getMockBuilder(Job::class)->disableOriginalConstructor()->getMock();
        $sender = $this->getMockBuilder(Sender::class)->getMock();
        $sender->expects($this->at(0))
            ->method('send')
            ->willReturnCallback(function ($notification) {
                $this->assertInstanceOf(JobCompletedNotification::class, $notification);
            });
        $event = new JobCompletedEvent($job);
        $listener = new NotificationSubscriber($sender);
        $listener->onJobCompleted($event);
    }
}
