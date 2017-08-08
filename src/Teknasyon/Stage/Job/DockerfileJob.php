<?php

namespace Teknasyon\Stage\Job;

use Teknasyon\Stage\Command;

class DockerfileJob extends JobAbstract
{
    public function getCommands()
    {
        return [
            Command\SetupBuildCommand::class,
            Command\DockerBuildCommand::class,
            Command\DockerRunCommand::class,
            Command\DockerStopCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
    }
}
