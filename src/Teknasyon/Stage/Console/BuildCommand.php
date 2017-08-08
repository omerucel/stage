<?php

namespace Teknasyon\Stage\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Teknasyon\Stage\CommandExecutor;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\Factory\ContainerFactory;
use Teknasyon\Stage\SuiteFactory;
use Teknasyon\Stage\SuiteSetting\SuiteSetting;
use Teknasyon\Stage\SuiteSettingParser;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this->setName('build')
            ->addOption('docker-compose-bin', 'dcb', InputOption::VALUE_REQUIRED, 'docker-compose çalıştırılabilir dosya yolu.')
            ->addOption('docker-bin', 'db', InputOption::VALUE_REQUIRED, 'docker çalıştırılabilir dosya yolu.')
            ->addOption('builds-dir', 'bd', InputOption::VALUE_REQUIRED, 'Testler belirtilen bu dizin içerisinde, teste özel dizin altında çalıştırılır.')
            ->addOption('outputs-dir', 'od', InputOption::VALUE_REQUIRED, 'Teste özel dizin içerisinde yer alan çıktı dosyaları, ilgili dizinle birlikte belirtilen bu dizine kopyalanır.')
            ->addOption('project-dir', 'pd', InputOption::VALUE_REQUIRED, 'Proje kök dizini')
            ->addOption('dry', null, InputOption::VALUE_NONE, 'Komutların çalıştırılmadan ekrana yazılmasını sağlar.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dockerComposeBin = $this->getValidatedDockerComposeBin($input);
        $dockerBin = $this->getValidatedDockerBin($input);
        $buildsDir = $this->getValidatedBuildsDir($input);
        $outputDir = $this->getValidatedOutputsDir($input);
        $projectDir = $this->getValidatedProjectDir($input);
        if ($input->getOption('dry') == true) {
            $commandExecutor = new class extends CommandExecutor {
                public function execute(array $args = [])
                {
                    echo implode(' ', $args) . PHP_EOL;
                    $process = new Process($args);
                    return $process;
                }
            };
        } else {
            $commandExecutor = new CommandExecutor();
        }
        $environmentSetting = new EnvironmentSetting([
            'docker_compose_bin' => $dockerComposeBin,
            'docker_bin' => $dockerBin,
            'builds_dir' => $buildsDir,
            'output_dir' => $outputDir
        ]);
        $container = ContainerFactory::factory();
        $container->set(EnvironmentSetting::class, $environmentSetting);
        $container->set(CommandExecutor::class, $commandExecutor);
        $suiteSettings = SuiteSettingParser::parse($projectDir . '/stage.yml');
        foreach ($suiteSettings as $suiteSetting) {
            $this->runSuite($container, $suiteSetting);
        }
    }

    protected function getValidatedDockerComposeBin(InputInterface $input)
    {
        $dockerComposeBin = realpath(trim($input->getOption('docker-compose-bin')));
        if ($dockerComposeBin == null) {
            throw new \Exception('docker-compose-bin ayarı gerekli.');
        }
        if (is_file($dockerComposeBin) == false || is_executable($dockerComposeBin) == false) {
            throw new \Exception('docker-compose-bin ayarı ile belirtilen dosya(' . $dockerComposeBin . ') geçersiz.');
        }
        return $dockerComposeBin;
    }

    protected function getValidatedDockerBin(InputInterface $input)
    {
        $dockerBin = realpath(trim($input->getOption('docker-bin')));
        if ($dockerBin == null) {
            throw new \Exception('docker-bin ayarı gerekli.');
        }
        if (is_file($dockerBin) == false || is_executable($dockerBin) == false) {
            throw new \Exception('docker-bin ayarı ile belirtilen dosya(' . $dockerBin . ') geçersiz.');
        }
        return $dockerBin;
    }

    protected function getValidatedBuildsDir(InputInterface $input)
    {
        $buildsDir = realpath(trim($input->getOption('builds-dir')));
        if ($buildsDir == null) {
            throw new \Exception('builds-dir ayarı gerekli.');
        }
        if ($buildsDir == '' || $buildsDir == '/' || is_dir($buildsDir) == false) {
            throw new \Exception('builds-dir ayarı ile belirtilen dizin(' . $buildsDir . ') geçersiz.');
        }
        return $buildsDir;
    }

    protected function getValidatedOutputsDir(InputInterface $input)
    {
        $outputsDir = realpath(trim($input->getOption('outputs-dir')));
        if ($outputsDir == null) {
            throw new \Exception('outputs-dir ayarı gerekli.');
        }
        if ($outputsDir == '' || $outputsDir == '/' || is_dir($outputsDir) == false) {
            throw new \Exception('outputs-dir ayarı ile belirtilen dizin(' . $outputsDir . ') geçersiz.');
        }
        return $outputsDir;
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
         */
        $suite = SuiteFactory::factory($container, $suiteSetting);
        foreach ($suite->getCommands() as $commandClass) {
            $command = $container->get($commandClass);
            $command->run($suite);
        }
    }
}
