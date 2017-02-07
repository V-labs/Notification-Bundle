<?php

namespace Vlabs\NotificationBundle\Manager;

use Vlabs\NotificationBundle\Factory\MessageFactory;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\Repository\NotificationRepository;
use Vlabs\NotificationBundle\Resolver\NotifierResolver;
use Vlabs\NotificationBundle\Notifier\NotifierInterface;
use Vlabs\NotificationBundle\VO\NotificationConfig;

class NotificationManager
{
    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var NotifierResolver
     */
    private $notifierResolver;

    public function __construct(
        NotificationRepository $notificationRepository,
        MessageFactory $messageFactory,
        NotifierResolver $notifierResolver
    ) {
        $this->notificationRepository   = $notificationRepository;
        $this->messageFactory           = $messageFactory;
        $this->notifierResolver = $notifierResolver;
    }

    /**
     * @param array $configs
     */
    public function batchNotify(array $configs = [])
    {
        foreach($configs as $config) {
            $this->notify($config);
        }
    }

    /**
     * Create a new message from config, and send it through wanted notifier
     *
     * @param NotificationConfig $config
     */
    public function notify(NotificationConfig $config)
    {
        /** @var MessageInterface $message */
        $message = $this->messageFactory->createFromConfig($config);
        $message->build();
        
        /** @var NotifierInterface $notifier */
        $notifier = $this->notifierResolver->get($message);
        $notifier->addToQueue($message);
    }
}