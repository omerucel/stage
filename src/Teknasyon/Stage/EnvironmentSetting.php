<?php

namespace Teknasyon\Stage;

class EnvironmentSetting
{
    public $dockerComposeBin;
    public $dockerBin;
    public $buildsDir;
    public $outputDir;
    public $notification;

    /**
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->dockerComposeBin = $settings['docker_compose_bin'] ?? null;
        $this->dockerBin = $settings['docker_bin'] ?? null;
        $this->buildsDir = $settings['builds_dir'] ?? null;
        $this->outputDir = $settings['output_dir'] ?? null;
        $this->notification = $settings['notification'] ?? [];
    }
}
