<?php

namespace Vlabs\NotificationBundle\Message;

use Vlabs\NotificationBundle\Entity\Notification;
use Vlabs\NotificationBundle\VO\NotificationConfig;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * @var NotificationConfig
     */
    protected $config;

    /**
     * @var Notification
     */
    protected $notification;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject = null;

    /**
     * @var string
     */
    protected $body;

    public function __construct(NotificationConfig $config, EngineInterface $templating)
    {
        $this->config = $config;
        $this->templating = $templating;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getType()
    {
        return $this->config->getType();
    }

    public function getAction()
    {
        return $this->config->getAction();
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}