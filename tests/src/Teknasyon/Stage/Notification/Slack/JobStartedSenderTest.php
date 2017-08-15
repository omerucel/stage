<?php

namespace Teknasyon\Stage\Notification\Slack;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\Job\DockerImageJob;
use Teknasyon\Stage\Notification\JobStartedNotification;
use Teknasyon\Stage\SuiteSetting\DockerImageSuiteSetting;

class JobStartedSenderTest extends TestCase
{
    public function testSend()
    {
        $environmentSetting = new EnvironmentSetting([
            'notification' => [
                'slack' => [
                    'webhook_url' => 'http://slack.com',
                    'icon_emoji' => ':rocket:',
                    'username' => 'stage'
                ]
            ]
        ]);
        $suiteSetting = new DockerImageSuiteSetting('suitename', [
            'notification' => [
                'slack' => [
                    'channel_name' => '#channel'
                ]
            ]
        ]);
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $job = new DockerImageJob($container, $suiteSetting);
        $notification = new JobStartedNotification($job);
        $container->expects($this->any())
            ->method('get')
            ->with(EnvironmentSetting::class)
            ->willReturn($environmentSetting);
        $guzzleClient = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $guzzleClient->expects($this->at(0))
            ->method('request')
            ->with(
                'POST',
                'http://slack.com',
                [
                    'json' => [
                        'channel' => '#channel',
                        'icon_emoji' => ':rocket:',
                        'username' => 'stage',
                        'text' => 'Job(suitename:' . $job->getGeneratedId() . ') started.'
                    ]
                ]
            );
        $sender = new JobStartedSender($guzzleClient, $environmentSetting);
        $sender->send($notification);
    }
}
