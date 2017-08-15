<?php

namespace Teknasyon\Stage\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Teknasyon\Stage\Event\JobCompletedEvent;
use Teknasyon\Stage\Event\JobStartedEvent;
use Teknasyon\Stage\Notification\JobCompletedNotification;
use Teknasyon\Stage\Notification\JobStartedNotification;
use Teknasyon\Stage\Notification\Sender;

class NotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var Sender
     */
    protected $sender;

    /**
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public static function getSubscribedEvents()
    {
        return [
            JobStartedEvent::NAME => 'onJobStarted',
            JobCompletedEvent::NAME => 'onJobCompleted'
        ];
    }

    /**
     * @param JobStartedEvent $event
     */
    public function onJobStarted(JobStartedEvent $event)
    {
        $notification = new JobStartedNotification($event->getJob());
        $this->sender->send($notification);
    }

    /**
     * @param JobCompletedEvent $event
     */
    public function onJobcompleted(JobCompletedEvent $event)
    {
        $notification = new JobCompletedNotification($event->getJob());
        $this->sender->send($notification);
    }
}
