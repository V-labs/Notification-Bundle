<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class RmsPushOptions extends AbstractMessageOptions
{
    const DATA   = 'data';
    const GCM    = 'gcm';
    const FCM    = 'fcm';
    const WEBFCM = 'webfcm';

    /**
     * RmsPushOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::DATA   => ['array'],
            self::GCM    => ['array'],
            self::FCM    => ['array'],
            self::WEBFCM => ['array']
        ];
    }
}