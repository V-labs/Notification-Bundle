<?php

namespace Vlabs\NotificationBundle\Notifier;

use Vlabs\NotificationBundle\Constant\DeviceConstant;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
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
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(Notifications $rmsNotifier, Logger $logger)
    {
        $this->rmsNotifier = $rmsNotifier;
        $this->logger = $logger;
    }

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        $this->logger->debug(sprintf('%s devices detected', count($message->getTo())));

        /** @var Device $device */
        foreach($message->getTo() as $device) {
            $this->logger->debug(sprintf('Token : %s', $device->getToken()));

            $rmsMessage = $this->getRmsMessage($device);

            $rmsMessage->setDeviceIdentifier($device->getToken());
            $rmsMessage->setMessage($message->getBody());

            $result = $this->rmsNotifier->send($rmsMessage);

            $this->logger->debug(sprintf('Message result : %s', $result));
        }
    }

    /**
     * @param Device $device
     * @return null|AndroidMessage|iOSMessage
     */
    private function getRmsMessage(Device $device)
    {
        switch ($device->getOs()) {

            case DeviceConstant::OS_ANDROID:
                $msg = new AndroidMessage();
                $msg->setGCM(true);
                return $msg;

            case DeviceConstant::OS_IOS:
                $msg = new iOSMessage();
                $msg->setAPSSound('default');
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
}