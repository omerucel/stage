<?php

namespace Teknasyon\Stage\SuiteSetting;

class DockerComposeSuiteSetting extends SuiteSettingAbstract
{
    public $dockerComposeFile;
    public $serviceName;

    /**
     * @param $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        parent::__construct($name, $settings);
        $this->dockerComposeFile = $settings['docker_compose_file'] ?? null;
        $this->serviceName = $settings['service_name'] ?? null;
    }
}
