<?php

namespace Teknasyon\Stage\SuiteSetting;

abstract class SuiteSettingAbstract implements SuiteSetting
{
    public $name;
    public $outputDir;
    public $command;
    public $sourceCodeDir;

    /**
     * @param $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        $this->name = $name;
        $this->outputDir = $settings['output_dir'] ?? [];
        if (is_array($this->outputDir) == false) {
            $this->outputDir = [$this->outputDir];
        }
        $this->command = $settings['command'] ?? null;
        $this->sourceCodeDir = $settings['source_code_dir'] ?? null;
    }
}
