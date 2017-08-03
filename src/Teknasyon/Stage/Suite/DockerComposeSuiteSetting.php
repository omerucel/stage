<?php

namespace Teknasyon\Stage\Suite;

use Teknasyon\Stage\SuiteSetting;

class DockerComposeSuiteSetting extends SuiteSetting
{
    public $dockerComposeFile;
    public $serviceName;

    /**
     * @param $name
     * @param array $settings
     */
    protected function __construct($name, array $settings)
    {
        parent::__construct($name, $settings);
        $this->dockerComposeFile = $settings['docker_compose_file'] ?? null;
        $this->serviceName = $settings['service_name'] ?? null;
    }
}
