<?php

namespace Vlabs\NotificationBundle\Notifier;

use Vlabs\NotificationBundle\Constant\DeviceConstant;
use Vlabs\NotificationBundle\DeviceInterface;
use Vlabs\NotificationBundle\Message\MessageInterface;
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;
use RMS\PushNotificationsBundle\Service\Notifications;

class RmsPushNotifier implements NotifierInterface
{
    const PUSH_TYPE = 'push';

    /**
     * @var Notifications
     */
    private $rmsNotifier;

    /**
     * @var array
     */
    private $config = [];

    /**
     * RmsPushNotifier constructor.
     * @param Notifications $rmsNotifier
     */
    public function __construct(Notifications $rmsNotifier)
    {
        $this->rmsNotifier = $rmsNotifier;
    }

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        /** @var DeviceInterface $device */
        foreach($message->getTo() as $device)
        {
            $rmsMessage = $this->getRmsMessage($device);

            $rmsMessage->setDeviceIdentifier($device->getToken());
            $rmsMessage->setMessage($message->getBody());
            $rmsMessage->setData($message->getData());

            $this->rmsNotifier->send($rmsMessage);
        }
    }

    /**
     * @param DeviceInterface $device
     * @return null|AndroidMessage|iOSMessage
     */
    private function getRmsMessage(DeviceInterface $device)
    {
        switch ($device->getOs()) {

            case DeviceConstant::OS_ANDROID:

                $msg = new AndroidMessage();
                $msg->setFCM(true);

                if(isset($this->config['gcm']) && $this->config['gcm'] === true)
                {
                    $msg->setFCM(false);
                    $msg->setGCM(true);
                }

                return $msg;

            case DeviceConstant::OS_IOS:

                $msg = new iOSMessage();
                $msg->setAPSSound('default');
                $msg->setAPSBadge($device->getUser()->getPushNotRead());

                return $msg;

        }

        return null;
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