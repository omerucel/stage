<?php

namespace Teknasyon\Stage\Job;

use Teknasyon\Stage\Command;

class DockerImageJob extends JobAbstract
{
    public function getCommands()
    {
        return [
            Command\SetupBuildCommand::class,
            Command\DockerRunImageCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
    }
}
