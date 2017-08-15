<?php

namespace Teknasyon\Stage\Notification;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Job\Job;

class JobStartedNotificationTest extends TestCase
{
    public function testParameters()
    {
        $job = $this->getMockBuilder(Job::class)->getMock();
        $notification = new JobStartedNotification($job);
        $this->assertEquals($job, $notification->getJob());
    }
}
