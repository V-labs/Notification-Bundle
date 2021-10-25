<?php

namespace Vlabs\NotificationBundle\Notifier;

use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\MessageData;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;
use RMS\PushNotificationsBundle\Message\WebMessage;
use Vlabs\NotificationBundle\DeviceInterface;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\MessageOptions\FirebasePushOptions;

class FirebasePushNotifier implements NotifierInterface
{
    const PUSH_TYPE = 'push';

    /**
     * @var array
     */
    private $config = [];

    /** @var Messaging */
    private $messaging;

    /**
     * RmsPushNotifier constructor.
     *
     * @param Messaging $messaging
     */
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        /** @var DeviceInterface $device */
        foreach ($message->getTo() as $device) {
            if ($messageOption = $message->getOptions()) {
                $title         = $messageOption->getValueForKey(FirebasePushOptions::TITLE);
                $imageUrl      = $messageOption->getValueForKey(FirebasePushOptions::IMAGE_URL);
                $data          = $messageOption->getValueForKey(FirebasePushOptions::DATA);
                $webPushConfig = $messageOption->getValueForKey(FirebasePushOptions::WEB_PUSH_CONFIG);
            }

            $cloudMessage = CloudMessage::withTarget('token', $device->getToken());

            // Do this first to do not erase next default configs
            if (isset($webPushConfig)) {
                $cloudMessage = $cloudMessage->withWebPushConfig(WebPushConfig::fromArray($webPushConfig));
            }

            if (isset($data)) {
                $cloudMessage = $cloudMessage->withData(MessageData::fromArray($data));
            }

            $cloudMessage = $cloudMessage
                ->withNotification(Notification::create($title ?: 'Notification', $message->getBody(), $imageUrl ?? null))
                ->withHighestPossiblePriority()
                ->withDefaultSounds(); // Enables default notifications sounds on iOS and Android devices.

            try {
                $this->messaging->send($cloudMessage);
            } catch (MessagingException $e) {} // fail silently so we can go to the next device
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::PUSH_TYPE;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}