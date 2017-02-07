<?php

namespace Vlabs\NotificationBundle\Notifier;

use Vlabs\NotificationBundle\Message\MessageInterface;

interface NotifierInterface
{
    /**
     * Add message in queue in this notifier channel
     */
    public function addToQueue(MessageInterface $message);

    /**
     * @return mixed
     */
    public function getType();
}