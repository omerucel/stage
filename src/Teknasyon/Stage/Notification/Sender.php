<?php

namespace Teknasyon\Stage\Notification;

interface Sender
{
    /**
     * @param Notification $notification
     */
    public function send(Notification $notification);
}
