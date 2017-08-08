<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Job\Job;

interface Command
{
    /**
     * @param Job $job
     */
    public function run(Job $job);
}
