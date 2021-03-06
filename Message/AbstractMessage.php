<?php

namespace Vlabs\NotificationBundle\Message;

use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Vlabs\NotificationBundle\Entity\Notification;
use Vlabs\NotificationBundle\MessageOptions\MessageOptionsInterface;
use Vlabs\NotificationBundle\VO\NotificationConfig;

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
     * @var Environment
     */
    protected $templating;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var string|array
     */
    protected $to;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var MessageOptionsInterface
     */
    protected $options;

    /**
     * AbstractMessage constructor.
     * @param NotificationConfig  $config
     * @param Environment         $templating
     * @param TranslatorInterface $translator
     */
    public function __construct(NotificationConfig $config, Environment $templating, TranslatorInterface $translator)
    {
        $this->config     = $config;
        $this->templating = $templating;
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array|string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->config->getType();
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->config->getAction();
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @return MessageOptionsInterface
     */
    public function getOptions()
    {
        return $this->options;
    }
}