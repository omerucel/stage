<?php

namespace Teknasyon\Stage\Job;

use Psr\Container\ContainerInterface;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;

abstract class JobAbstract implements Job
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EnvironmentSetting
     */
    public $environmentSetting;

    /**
     * @var SuiteSetting
     */
    public $suiteSetting;

    /**
     * @var string
     */
    protected $id;

    /**
     * @param ContainerInterface $container
     * @param SuiteSetting $suiteSetting
     */
    public function __construct(ContainerInterface $container, SuiteSetting $suiteSetting)
    {
        $this->container = $container;
        $this->suiteSetting = $suiteSetting;
        $this->environmentSetting = $container->get(EnvironmentSetting::class);
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
