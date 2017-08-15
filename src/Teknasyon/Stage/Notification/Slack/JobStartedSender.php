<?php

namespace Teknasyon\Stage\Notification\Slack;

use GuzzleHttp\Client;
use Teknasyon\Stage\EnvironmentSetting;
use Teknasyon\Stage\Notification\JobStartedNotification;
use Teknasyon\Stage\Notification\Notification;
use Teknasyon\Stage\Notification\Sender;

class JobStartedSender implements Sender
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var EnvironmentSetting
     */
    protected $environmentSetting;

    /**
     * @param Client $guzzleClient
     * @param EnvironmentSetting $environmentSetting
     */
    public function __construct(Client $guzzleClient, EnvironmentSetting $environmentSetting)
    {
        $this->guzzleClient = $guzzleClient;
        $this->environmentSetting = $environmentSetting;
    }

    public function send(Notification $notification)
    {
        if (!$notification instanceof JobStartedNotification) {
            return;
        }
        /**
         * @var JobStartedNotification $notification
         */
        $url = $this->environmentSetting->notification['slack']['webhook_url'];
        $job = $notification->getJob();
        $json = [
            'channel' => $job->suiteSetting->notificationSettings['slack']['channel_name'],
            'username' => $this->environmentSetting->notification['slack']['username'],
            'text' => 'Job(' . $job->suiteSetting->name . ':' . $job->getGeneratedId() . ') started.',
            'icon_emoji' => $this->environmentSetting->notification['slack']['icon_emoji']
        ];
        $this->guzzleClient->request('POST', $url, ['json' => $json]);
    }
}
