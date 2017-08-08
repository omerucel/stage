<?php

namespace Teknasyon\Stage\Suite;

interface Suite
{
    /**
     * @return string
     */
    public function getGeneratedId();

    /**
     * @return string
     */
    public function getBuildDir();

    /**
     * @return string
     */
    public function getOutputDir();

    /**
     * @return array
     */
    public function getCommands();
}
