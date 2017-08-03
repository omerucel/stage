<?php

namespace Teknasyon\Stage\Suite;

use Teknasyon\Stage\SuiteSetting;

class DockerfileSuiteSetting extends SuiteSetting
{
    public $dockerfile;
    public $sourceCodeTarget;

    /**
     * @param $name
     * @param array $settings
     */
    protected function __construct($name, array $settings)
    {
        parent::__construct($name, $settings);
        $this->dockerfile = $settings['dockerfile'] ?? null;
        $this->sourceCodeTarget = $settings['source_code_target'] ?? null;
    }
}
