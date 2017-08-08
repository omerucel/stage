<?php

namespace Teknasyon\Stage\Suite;

use Teknasyon\Stage\Command;

class DockerComposeSuite extends SuiteAbstract
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
