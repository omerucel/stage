<?php

namespace Teknasyon\Stage;

use Teknasyon\Stage\Suite\DockerComposeSuiteSetting;
use Teknasyon\Stage\Suite\DockerfileSuiteSetting;

class SuiteSetting
{
    public $name;
    public $outputDir;
    public $command;

    /**
     * @param $name
     * @param array $settings
     */
    protected function __construct($name, array $settings)
    {
        $this->name = $name;
        $this->outputDir = $settings['output_dir'] ?? [];
        if (is_array($this->outputDir) == false) {
            $this->outputDir = [$this->outputDir];
        }
        $this->command = $settings['command'] ?? null;
    }

    /**
     * @param $name
     * @param array $settings
     * @return SuiteSetting
     */
    public static function factory($name, array $settings)
    {
        if (isset($settings['docker_compose_file'])) {
            $class = DockerComposeSuiteSetting::class;
        } elseif ($settings['dockerfile']) {
            $class = DockerfileSuiteSetting::class;
        }
        return new $class($name, $settings);
    }
}
