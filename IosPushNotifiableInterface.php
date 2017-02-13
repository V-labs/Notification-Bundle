<?php

namespace Vlabs\NotificationBundle;

interface IosPushNotifiableInterface
{
    /**
     * @return integer
     */
    public function getPushNotRead();
}