<?php

namespace Teknasyon\Stage;

class EnvironmentSetting
{
    public $dockerComposeBin;
    public $buildsDir;
    public $outputDir;

    /**
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->dockerComposeBin = $settings['docker_compose_bin'] ?? null;
        $this->buildsDir = $settings['builds_dir'] ?? null;
        $this->outputDir = $settings['output_dir'] ?? null;
    }
}
