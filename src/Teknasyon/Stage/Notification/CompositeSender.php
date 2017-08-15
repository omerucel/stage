<?php

namespace Teknasyon\Stage\Notification;

class CompositeSender implements Sender
{
    /**
     * @var array
     */
    protected $childSenders = [];

    /**
     * @param Sender $sender
     */
    public function addSender(Sender $sender)
    {
        $this->childSenders[] = $sender;
    }

    /**
     * @param Notification $notification
     */
    public function send(Notification $notification)
    {
        foreach ($this->childSenders as $childSender) {
            $childSender->send($notification);
        }
    }
}
