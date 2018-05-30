<?php

namespace Vlabs\NotificationBundle\MessageOptions;

interface MessageOptionsInterface
{
    /**
     * @param $key
     * @param $value
     */
    public function setValueForKey($key, $value);

    /**
     * @param $key
     */
    public function getValueForKey($key);
}