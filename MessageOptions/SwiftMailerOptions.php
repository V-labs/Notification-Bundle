<?php

namespace Vlabs\NotificationBundle\MessageOptions;

class SwiftMailerOptions extends AbstractMessageOptions
{
    const FROM_EMAIL  = 'from_email';
    const FROM_NAME   = 'from_name';
    const SUBJECT     = 'subject';
    const CC          = 'cc';
    const BCC         = 'bcc';
    const REPLY_TO    = 'reply_to';
    const ATTACHMENTS = 'attachments';

    /**
     * SwiftMailerOptions constructor.
     */
    public function __construct()
    {
        $this->availableOptions = [
            self::FROM_EMAIL    => ['string'],
            self::FROM_NAME     => ['string'],
            self::SUBJECT       => ['string'],
            self::CC            => ['string', 'string[]'],
            self::BCC           => ['string', 'string[]'],
            self::REPLY_TO      => ['string', 'string[]'],
            self::ATTACHMENTS   => ['array']
        ];
    }
}