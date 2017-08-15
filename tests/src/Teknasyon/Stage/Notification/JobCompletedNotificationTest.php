<?php

namespace Teknasyon\Stage\Notification;

use PHPUnit\Framework\TestCase;
use Teknasyon\Stage\Job\Job;

class JobCompletedNotificationTest extends TestCase
{
    public function testParameters()
    {
        $job = $this->getMockBuilder(Job::class)->getMock();
        $notification = new JobCompletedNotification($job);
        $this->assertEquals($job, $notification->getJob());
    }
}
