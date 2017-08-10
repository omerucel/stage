<?php

namespace Teknasyon\Stage\Event\Subscriber;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Teknasyon\Stage\Event\CmdExecuteEvent;
use Teknasyon\Stage\Event\ProcessOutputEvent;
use Teknasyon\Stage\Job\DockerImageJob;
use Teknasyon\Stage\Job\Job;

class BuildLogSubscriberTest extends TestCase
{
    public function testSubscribedEvents()
    {
        $expected = [
            CmdExecuteEvent::NAME => 'onCmdExecute',
            ProcessOutputEvent::NAME => 'onProcessOutput'
        ];
        $this->assertEquals($expected, BuildLogSubscriber::getSubscribedEvents());
    }

    public function testCmdExecuteEvent()
    {
        $job = $this->getMockBuilder(DockerImageJob::class)->disableOriginalConstructor()->getMock();
        $job->expects($this->any())
            ->method('getOutputDir')
            ->willReturn('/outputs/build');
        $filesystem = $this->getMockBuilder(Filesystem::class)->getMock();
        $filesystem->expects($this->at(0))
            ->method('appendToFile')
            ->willReturnCallback(function ($fileName, $content) use ($job) {
                $this->assertEquals('/outputs/build/build.log', $fileName);
                $this->assertEquals('php -v' . PHP_EOL, $content);
            });
        /**
         * @var Job $job
         * @var Filesystem $filesystem
         */
        $cmd = ['php', '-v'];
        $event = new CmdExecuteEvent($cmd, $job);
        $listener = new BuildLogSubscriber($filesystem);
        $listener->onCmdExecute($event);
    }

    public function testProcessOutputEvent()
    {
        $job = $this->getMockBuilder(DockerImageJob::class)->disableOriginalConstructor()->getMock();
        $job->expects($this->any())
            ->method('getOutputDir')
            ->willReturn('/outputs/build');
        $filesystem = $this->getMockBuilder(Filesystem::class)->getMock();
        $filesystem->expects($this->at(0))
            ->method('appendToFile')
            ->willReturnCallback(function ($fileName, $content) use ($job) {
                $this->assertEquals('/outputs/build/build.log', $fileName);
                $this->assertEquals('buffer1' . PHP_EOL, $content);
            });
        /**
         * @var Job $job
         * @var Filesystem $filesystem
         */
        $event = new ProcessOutputEvent('type1', 'buffer1' . PHP_EOL, $job);
        $listener = new BuildLogSubscriber($filesystem);
        $listener->onProcessOutput($event);
    }
}
