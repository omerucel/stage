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
    protected $id;

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
    }

    /**
     * @return string
     */
    public function getBuildDir()
    {
        return $this->environmentSetting->buildsDir . '/' . $this->getGeneratedId();
    }

    /**
     * @return string
     */
    public function getOutputDir()
    {
        return $this->environmentSetting->outputDir . '/' . $this->getGeneratedId();
    }

    /**
     * @return string
     */
    public function getGeneratedId()
    {
        if ($this->id == null) {
            $this->id = md5(uniqid(time() . getmypid()));
        }
        return $this->id;
    }
}
