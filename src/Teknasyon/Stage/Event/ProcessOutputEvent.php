<?php

namespace Teknasyon\Stage\Event;

use Symfony\Component\EventDispatcher\Event;
use Teknasyon\Stage\Job\Job;

class ProcessOutputEvent extends Event
{
    const NAME = 'process.output';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * @var Job
     */
    protected $job;

    /**
     * @param $type
     * @param $buffer
     * @param Job $job
     */
    public function __construct($type, $buffer, Job $job)
    {
        $this->type = $type;
        $this->buffer = $buffer;
        $this->job = $job;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBuffer()
    {
        return $this->buffer;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}
