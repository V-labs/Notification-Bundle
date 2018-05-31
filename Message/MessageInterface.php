<?php

namespace Vlabs\NotificationBundle\Message;

use Vlabs\NotificationBundle\Entity\Notification;
use Vlabs\NotificationBundle\MessageOptions\MessageOptionsInterface;

/**
 * Describe how a message works
 *
 * Interface MessageInterface
 * @package Vlabs\NotificationBundle\Message
 */
interface MessageInterface
{
    /**
     * Render template and set wanted parameters for notifier future usage
     *
     * @return mixed
     */
    public function build();

    /**
     * The resolvable name of the twig template
     *
     * @return string
     */
    public function getTemplate($type = 'body');

    /**
     * Notifier which will be used
     *
     * @return string
     */
    public function getType();

    /**
     * Action that lead to this message
     *
     * @return string
     */
    public function getAction();

    /**
     * The persistable notification
     *
     * @return Notification
     */
    public function getNotification();

    /**
     * @return string
     */
    public function getBody();

    /**
     * @return string|array
     */
    public function getTo();

    /**
     * @return MessageOptionsInterface
     */
    public function getOptions();
}