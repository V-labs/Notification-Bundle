<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class OvhSmsOptions extends AbstractMessageOptions
{
    const SENDER = 'sender';

    /**
     * OvhSmsOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::SENDER => ['string']
        ];
    }
}