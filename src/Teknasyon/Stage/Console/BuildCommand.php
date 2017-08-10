<?php

namespace Teknasyon\Stage\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Teknasyon\Stage\CommandExecutor;
use Teknasyon\Stage\DummyCommandExecutor;
use Teknasyon\Stage\Event\JobCompletedEvent;
use Teknasyon\Stage\Event\JobStartedEvent;
use Teknasyon\Stage\Factory\ContainerFactory;
use Teknasyon\Stage\JobFactory;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;
use Teknasyon\Stage\SuiteSettingParser;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this->setName('build')
            ->addOption('environment-file', 'ef', InputOption::VALUE_REQUIRED, 'Ortam ayarlarının bulunduğu yaml dosyası.')
            ->addOption('project-dir', 'pd', InputOption::VALUE_REQUIRED, 'Proje kök dizini')
            ->addOption('dry', null, InputOption::VALUE_NONE, 'Komutların çalıştırılmadan ekrana yazılmasını sağlar.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environmentFilePath = $this->getValidatedEnvironmentFile($input);
        $projectDir = $this->getValidatedProjectDir($input);
        $container = ContainerFactory::factory($environmentFilePath);
        if ($input->getOption('dry') == true) {
            $container->set(CommandExecutor::class, \DI\object(DummyCommandExecutor::class));
        }
        $suiteSettings = SuiteSettingParser::parse($projectDir . '/stage.yml');
        foreach ($suiteSettings as $suiteSetting) {
            $this->runSuite($container, $suiteSetting);
        }
    }

    protected function getValidatedEnvironmentFile(InputInterface $input)
    {
        $environmentFilePath = $input->getOption('environment-file');
        if ($environmentFilePath == null) {
            throw new \Exception('environment-file ayarı gerekli.');
        }
        $environmentFilePath = realpath($environmentFilePath);
        if (is_file($environmentFilePath) == false || is_readable($environmentFilePath) == false) {
            throw new \Exception('environment-file ayarı ile belirtilen dosya(' . $environmentFilePath . ') geçersiz.');
        }
        return $environmentFilePath;
    }

    protected function getValidatedProjectDir(InputInterface $input)
    {
        $projectDir = realpath(trim($input->getOption('project-dir')));
        if ($projectDir == null) {
            throw new \Exception('project-dir ayarı gerekli.');
        }
        if ($projectDir == '' || $projectDir == '/' || is_dir($projectDir) == false) {
            throw new \Exception('project-dir ayarı ile belirtilen dizin(' . $projectDir . ') geçersiz.');
        }
        if (is_file($projectDir . '/stage.yml') == false) {
            throw new \Exception('project-dir ayarı ile belirtilen dizinde(' . $projectDir . ') stage.yml dosyası bulunamadı.');
        }
        return $projectDir;
    }

    protected function runSuite(ContainerInterface $container, SuiteSetting $suiteSetting)
    {
        /**
         * @var \Teknasyon\Stage\Command\Command $command
         * @var EventDispatcher $eventDispatcher
         */
        $job = JobFactory::factory($container, $suiteSetting);
        $eventDispatcher = $container->get(EventDispatcher::class);
        $jobStarted = new JobStartedEvent($job);
        $eventDispatcher->dispatch($jobStarted::NAME, $jobStarted);
        foreach ($job->getCommands() as $commandClass) {
            $command = $container->get($commandClass);
            $command->run($job);
        }
        $jobCompleted = new JobCompletedEvent($job);
        $eventDispatcher->dispatch($jobCompleted::NAME, $jobCompleted);
    }
}
