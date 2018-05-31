<?php

namespace Vlabs\NotificationBundle\Notifier;

use RMS\PushNotificationsBundle\Message\WebMessage;
use Vlabs\NotificationBundle\Constant\DeviceConstant;
use Vlabs\NotificationBundle\DeviceInterface;
use Vlabs\NotificationBundle\Message\AbstractMessage;
use Vlabs\NotificationBundle\Message\MessageInterface;
use RMS\PushNotificationsBundle\Message\AndroidMessage;
use RMS\PushNotificationsBundle\Message\iOSMessage;
use RMS\PushNotificationsBundle\Service\Notifications;
use Vlabs\NotificationBundle\MessageOptions\RmsPushOptions;

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
            if ($messageOption = $message->getOptions()) {
                $data = $messageOption->getValueForKey(RmsPushOptions::DATA);
            }

            $rmsMessage = $this->getRmsMessage($device, $message);

            $rmsMessage->setDeviceIdentifier($device->getToken());
            $rmsMessage->setMessage($message->getBody());
            $rmsMessage->setData(isset($data) ? $data : []);

            $this->rmsNotifier->send($rmsMessage);
        }
    }

    /**
     * @param DeviceInterface $device
     * @param AbstractMessage $message
     * @return null|AndroidMessage|iOSMessage
     */
    private function getRmsMessage(DeviceInterface $device, MessageInterface $message)
    {
        if ($messageOption = $message->getOptions()) {
            $gcm    = $messageOption->getValueForKey(RmsPushOptions::GCM);
            $fcm    = $messageOption->getValueForKey(RmsPushOptions::FCM);
            $webFcm = $messageOption->getValueForKey(RmsPushOptions::WEBFCM);
        }

        switch ($device->getOs()) {

            case DeviceConstant::OS_ANDROID:

                $msg = new AndroidMessage();

                if (isset($this->config['gcm']) && $this->config['gcm'] === true && isset($gcm)) {
                    $msg->setGCM(true);
                    $msg->setGCMOptions($gcm);
                } else if (isset($fcm)) {
                    $msg->setFCM(true);
                    $msg->setFCMOptions($fcm);
                }

                return $msg;

            case DeviceConstant::OS_IOS:

                $msg = new iOSMessage();
                $msg->setAPSSound('default');
                $msg->setAPSBadge($device->getUser()->getPushNotRead());

                return $msg;

            case DeviceConstant::OS_WEB:

                $msg = new WebMessage();

                if (isset($webFcm)) {
                    $msg->setWebFCMOptions($webFcm);
                }

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