<?php

namespace Vlabs\NotificationBundle\Notifier;

use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;
use RMS\PushNotificationsBundle\Message\WebMessage;
use Vlabs\NotificationBundle\Constant\DeviceConstant;
use Vlabs\NotificationBundle\DeviceInterface;
use Vlabs\NotificationBundle\Message\AbstractMessage;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\MessageOptions\FirebasePushOptions;
use Vlabs\NotificationBundle\MessageOptions\RmsPushOptions;
use Vlabs\NotificationBundle\MessageOptions\SwiftMailerOptions;

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
                $title = $messageOption->getValueForKey(FirebasePushOptions::TITLE);
            }

            $cloudMessage = CloudMessage::withTarget('token', $device->getToken())
                ->withNotification(Notification::create($title ?: 'Notification', $message->getBody()))
                ->withDefaultSounds(); // Enables default notifications sounds on iOS and Android devices.

            try {
                $this->messaging->send($cloudMessage);
            } catch (NotFound $e) {} // fail silently so we can go to the next device
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