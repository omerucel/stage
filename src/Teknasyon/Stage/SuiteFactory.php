<?php

namespace Teknasyon\Stage;

use Psr\Container\ContainerInterface;
use Teknasyon\Stage\Suite\DockerComposeSuite;
use Teknasyon\Stage\Suite\DockerfileSuite;
use Teknasyon\Stage\SuiteSetting\DockerComposeSuiteSetting;
use Teknasyon\Stage\SuiteSetting\DockerfileSuiteSetting;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;

class SuiteFactory
{
    /**
     * @param ContainerInterface $container
     * @param SuiteSetting $suiteSetting
     * @return DockerComposeSuite|DockerfileSuite
     */
    public static function factory(ContainerInterface $container, SuiteSetting $suiteSetting)
    {
        if ($suiteSetting instanceof DockerComposeSuiteSetting) {
            return new DockerComposeSuite($container, $suiteSetting);
        } elseif ($suiteSetting instanceof DockerfileSuiteSetting) {
            return new DockerfileSuite($container, $suiteSetting);
        }
    }
}
