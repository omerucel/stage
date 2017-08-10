<?php

namespace Teknasyon\Stage\Event;

use Symfony\Component\EventDispatcher\Event;
use Teknasyon\Stage\Job\Job;

class CmdExecuteEvent extends Event
{
    const NAME = 'cmd.execute';

    /**
     * @var Job
     */
    protected $job;

    /**
     * @var array
     */
    protected $cmd;

    /**
     * @param array $cmd
     * @param Job $job
     */
    public function __construct(array $cmd, Job $job)
    {
        $this->cmd = $cmd;
        $this->job = $job;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @return array
     */
    public function getCmd()
    {
        return $this->cmd;
    }
}
