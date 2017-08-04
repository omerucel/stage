<?php

namespace Teknasyon\Stage\Command;

use Teknasyon\Stage\Suite\Suite;

interface Command
{
    /**
     * @param Suite $suite
     */
    public function run(Suite $suite);
}
