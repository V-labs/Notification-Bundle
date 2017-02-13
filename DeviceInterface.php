<?php

namespace Vlabs\NotificationBundle;

interface DeviceInterface
{
    public function getOs();

    public function getToken();

    /**
     * @return IosPushNotifiableInterface
     */
    public function getUser();
}