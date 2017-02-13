<?php

namespace Vlabs\NotificationBundle\Message;

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
     * @return mixed
     */
    public function getTemplate($type = 'body');

    /**
     * Notifier which will be used
     *
     * @return mixed
     */
    public function getType();

    /**
     * Action that lead to this message
     *
     * @return mixed
     */
    public function getAction();

    /**
     * The persistable notification
     *
     * @return mixed
     */
    public function getNotification();

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @return mixed
     */
    public function getTo();

    /**
     * @return mixed
     */
    public function getSubject();

    /**
     * @return array
     */
    public function getData();
}