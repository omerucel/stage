<?php

namespace Teknasyon\Stage\Event;

use Symfony\Component\EventDispatcher\Event;
use Teknasyon\Stage\Job\Job;

class JobStartedEvent extends Event
{
    const NAME = 'job.started';

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
