<?php

namespace Teknasyon\Stage;

class Build
{
    /**
     * @var EnvironmentSetting
     */
    public $environmentSetting;

    /**
     * @var ProjectSetting
     */
    public $projectSetting;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $buildDir;

    /**
     * @var string
     */
    public $dockerComposeFile;

    /**
     * @var string
     */
    public $outputDir;

    /**
     * @param EnvironmentSetting $environmentSetting
     * @param ProjectSetting $projectSetting
     */
    public function __construct(EnvironmentSetting $environmentSetting, ProjectSetting $projectSetting)
    {
        $this->environmentSetting = $environmentSetting;
        $this->projectSetting = $projectSetting;
        $this->id = md5(uniqid(time() . getmypid()));
        $this->buildDir = $this->environmentSetting->buildsDir . '/' . $this->id;
        $this->outputDir = $this->environmentSetting->outputDir . '/' . $this->id;
        $this->dockerComposeFile = $this->buildDir . '/' . $projectSetting->dockerComposeFile;
    }
}
