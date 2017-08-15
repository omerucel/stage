<?php

namespace Teknasyon\Stage\Notification;

use Teknasyon\Stage\Job\Job;

class JobStartedNotification implements Notification
{
    /**
     * @var Job
     */
    protected $job;

    /**
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
