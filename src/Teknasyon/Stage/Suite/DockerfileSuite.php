<?php

namespace Teknasyon\Stage\Suite;

use Teknasyon\Stage\Command;

class DockerfileSuite extends SuiteAbstract
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
