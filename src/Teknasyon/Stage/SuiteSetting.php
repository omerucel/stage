<?php

namespace Teknasyon\Stage;

class SuiteSetting
{
    public $name;
    public $dockerComposeFile;
    public $serviceName;
    public $outputDir;
    public $command;

    /**
     * @param $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        $this->name = $name;
        $this->dockerComposeFile = $settings['docker_compose_file'] ?? null;
        $this->serviceName = $settings['service_name'] ?? null;
        $this->outputDir = $settings['output_dir'] ?? null;
        $this->command = $settings['command'] ?? null;
    }
}
