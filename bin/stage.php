<?php

include_once realpath(dirname(__DIR__)) . '/vendor/autoload.php';

$console = new Symfony\Component\Console\Application();
$console->add(new \Teknasyon\Stage\Console\BuildCommand());
$console->run();
