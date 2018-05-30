<?php

namespace Vlabs\NotificationBundle\Message;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Vlabs\NotificationBundle\Entity\Notification;
use Vlabs\NotificationBundle\Exception\MessageDoesNotSupportAttachments;
use Vlabs\NotificationBundle\MessageOption\MessageOptionInterface;
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
     * @var Translator
     */
    protected $translator;

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

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $fcmOptions;

    /**
     * @var array
     */
    protected $gcmOptions;

    /**
     * @var array
     */
    protected $webFcmOptions;

    /**
     * @var MessageOptionInterface
     */
    protected $messageOption;

    /**
     * AbstractMessage constructor.
     * @param NotificationConfig $config
     * @param EngineInterface $templating
     * @param TranslatorInterface $translator
     */
    public function __construct(NotificationConfig $config, EngineInterface $templating, TranslatorInterface $translator)
    {
        $this->config = $config;
        $this->templating = $templating;
        $this->translator = $translator;
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

    public function getData()
    {
        return $this->data;
    }

    public function getFCMOptions()
    {
        return $this->fcmOptions;
    }

    public function getGCMOptions()
    {
        return $this->gcmOptions;
    }

    public function getAttachments()
    {
        throw new MessageDoesNotSupportAttachments();
    }

    public function getWebFCMOptions()
    {
        return $this->webFcmOptions;
    }

    /**
     * @return MessageOptionInterface
     */
    public function getMessageOption()
    {
        return $this->messageOption;
    }
}