<?php

namespace Vlabs\NotificationBundle;

interface DeviceInterface
{
    public function getOs();

    public function getToken();
}