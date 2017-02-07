<?php

namespace Vlabs\NotificationBundle\VO;

class NotificationConfig
{
    private $action;
    private $type;
    private $data;

    /**
     * Describe a message, triggered after an action
     *
     * @param $action
     * @param string $notificationType
     * @param $data
     */
    public function __construct($action = null, $notificationType = null, $data)
    {
        if(is_null($action)){
            throw new \InvalidArgumentException('$action must be one of your triggered event');
        }

        if(is_null($notificationType)){
            throw new \InvalidArgumentException('$notificationType must be one of NotifierInterface::getType value');
        }

        $this->action = $action;
        $this->type = $notificationType;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}