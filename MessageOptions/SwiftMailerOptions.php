<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class SwiftMailerOptions extends AbstractMessageOptions
{
    const SUBJECT       = 'subject';
    const CC            = 'cc';
    const BCC           = 'bcc';
    const REPLY_TO      = 'replyTo';
    const ATTACHMENTS   = 'attachments';

    /**
     * SwiftMailerOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::SUBJECT       => ['string'],
            self::CC            => ['string', 'string[]'],
            self::BCC           => ['string', 'string[]'],
            self::REPLY_TO      => ['string', 'string[]'],
            self::ATTACHMENTS   => ['array']
        ];
    }
}