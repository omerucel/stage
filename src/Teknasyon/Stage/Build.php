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
     * @var SuiteSetting
     */
    public $suiteSetting;

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
     * @param SuiteSetting $suiteSetting
     */
    public function __construct(
        EnvironmentSetting $environmentSetting,
        ProjectSetting $projectSetting,
        SuiteSetting $suiteSetting
    ) {
        $this->environmentSetting = $environmentSetting;
        $this->projectSetting = $projectSetting;
        $this->suiteSetting = $suiteSetting;
        $this->id = md5(uniqid(time() . getmypid()));
        $this->buildDir = $this->environmentSetting->buildsDir . '/' . $this->id;
        $this->outputDir = $this->environmentSetting->outputDir . '/' . $this->id;
        $this->dockerComposeFile = $this->buildDir . '/' . $suiteSetting->dockerComposeFile;
    }
}
