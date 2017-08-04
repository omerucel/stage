<?php

namespace Teknasyon\Stage\SuiteSetting;

class DockerfileSuiteSetting extends SuiteSettingAbstract
{
    public $dockerfile;
    public $sourceCodeTarget;

    /**
     * @param $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        parent::__construct($name, $settings);
        $this->dockerfile = $settings['dockerfile'] ?? null;
        $this->sourceCodeTarget = $settings['source_code_target'] ?? null;
    }
}
