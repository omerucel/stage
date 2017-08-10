<?php

namespace Teknasyon\Stage\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;

class BuildLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public static function getSubscribedEvents()
    {
        return [
            CmdExecuteEvent::NAME => 'onCmdExecute',
            ProcessOutputEvent::NAME => 'onProcessOutput'
        ];
    }

    public function onCmdExecute(CmdExecuteEvent $event)
    {
        $filename = $event->getJob()->getOutputDir() . '/build.log';
        $this->filesystem->appendToFile($filename, implode(' ', $event->getCmd()) . PHP_EOL);
    }

    public function onProcessOutput(ProcessOutputEvent $event)
    {
        $filename = $event->getJob()->getOutputDir() . '/build.log';
        $this->filesystem->appendToFile($filename, trim($event->getBuffer()) . PHP_EOL);
    }
}
