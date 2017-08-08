<?php

namespace Teknasyon\Stage\Suite;

use Teknasyon\Stage\Command;

class DockerImageSuite extends SuiteAbstract
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
