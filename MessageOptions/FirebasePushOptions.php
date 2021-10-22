<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class FirebasePushOptions extends AbstractMessageOptions
{
    const TITLE            = 'title';
    const IMAGE_URL        = 'image_url';
    const DATA             = 'data';
    const WEB_PUSH_CONFIG  = 'web_push_config';

    /**
     * FirebasePushOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::TITLE           => ['string'],
            self::IMAGE_URL       => ['string'],
            self::DATA            => ['array'],
            self::WEB_PUSH_CONFIG => ['array']
        ];
    }
}