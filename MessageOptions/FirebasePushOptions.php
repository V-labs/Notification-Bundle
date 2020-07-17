<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class FirebasePushOptions extends AbstractMessageOptions
{
    const TITLE = 'title';

    /**
     * RmsPushOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::TITLE => ['string'],
        ];
    }
}