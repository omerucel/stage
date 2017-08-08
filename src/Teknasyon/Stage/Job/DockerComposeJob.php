<?php

namespace Teknasyon\Stage\Job;

use Teknasyon\Stage\Command;

class DockerComposeJob extends JobAbstract
{
    public function getCommands()
    {
        return [
            Command\SetupBuildCommand::class,
            Command\DockerComposeUpCommand::class,
            Command\DockerComposeRunCommand::class,
            Command\DockerComposeRmCommand::class,
            Command\MoveOutputCommand::class,
            Command\CleanBuildCommand::class
        ];
    }
}
