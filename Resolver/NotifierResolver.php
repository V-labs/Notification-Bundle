<?php

namespace Vlabs\NotificationBundle\Resolver;

use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\Notifier\NotifierInterface;

class NotifierResolver
{
    protected $notifiers = [];

    /**
     * Retrieve good notifier service based on type
     *
     * @param MessageInterface $message
     * @return mixed
     */
    public function get(MessageInterface $message)
    {
        return $this->notifiers[$message->getType()];
    }

    /**
     * Register new notifier
     *
     * @param NotifierInterface $notifier
     */
    public function addNotifier(NotifierInterface $notifier)
    {
        $this->notifiers[$notifier->getType()] = $notifier;
    }
}