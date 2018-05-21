<?php

namespace Vlabs\NotificationBundle\VO;

use Vlabs\NotificationBundle\Constant\ConfigConstant;

class NotificationConfig
{
    private $action;
    private $type;
    private $rootDir;
    private $data;

    /**
     * Describe a message, triggered after an action
     *
     * @param $action
     * @param string $notificationType
     * @param string $rootDir
     * @param $data
     */
    public function __construct($action = null, $notificationType = null, $rootDir = ConfigConstant::DEFAULT_ROOT_DIR, $data)
    {
        if(is_null($action)){
            throw new \InvalidArgumentException('$action must be one of your triggered event');
        }

        if(is_null($notificationType)){
            throw new \InvalidArgumentException('$notificationType must be one of NotifierInterface::getType value');
        }

        $this->action = $action;
        $this->type = $notificationType;
        $this->rootDir = $rootDir;
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

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }
}