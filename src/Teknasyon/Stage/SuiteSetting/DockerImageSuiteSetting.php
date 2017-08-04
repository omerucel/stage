<?php

namespace Teknasyon\Stage\SuiteSetting;

class DockerImageSuiteSetting extends SuiteSettingAbstract
{
    public $dockerimage;
    public $sourceCodeTarget;

    /**
     * @param $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        parent::__construct($name, $settings);
        $this->dockerimage = $settings['dockerimage'] ?? null;
        $this->sourceCodeTarget = $settings['source_code_target'] ?? null;
    }
}
