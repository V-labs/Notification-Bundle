<?php

namespace Vlabs\NotificationBundle;

interface SmsNotifiableInterface
{
    /**
     * @return string
     */
    public function getSmsPhoneNumber();
}