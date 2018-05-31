<?php

namespace Vlabs\NotificationBundle\MessageOptions;

interface MessageOptionsInterface
{
    /**
     * @param string $key
     * @param mixed $value
     */
    public function validateOption($key, $value);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValueForKey($key, $value);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getValueForKey($key);
}