<?php

namespace Vlabs\NotificationBundle\Factory;

use Vlabs\NotificationBundle\MessageInterface;
use Vlabs\NotificationBundle\VO\NotificationConfig;
use Symfony\Component\Templating\EngineInterface;

class MessageFactory
{
    /**
     * @var string
     */
    protected $vendorName;

    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(EngineInterface $templating, $vendorName)
    {
        $this->templating = $templating;
        $this->vendorName = $vendorName;
    }

    /**
     * @param NotificationConfig $config
     * @return MessageInterface
     */
    public function createFromConfig(NotificationConfig $config)
    {
        $action = $config->getAction();
        $type = $config->getType();

        $actionParts = explode('_', $action);
        $camelizedAction = $this->camelize($action);

        $classNS = sprintf('%s\%sBundle\Notification\%s\%s',
            ucfirst($this->vendorName),
            ucfirst($actionParts[0]),
            ucfirst($type),
            $camelizedAction
        );

        $reflectedMessage = new \ReflectionClass($classNS);

        return $reflectedMessage->newInstance($config, $this->templating);
    }

    /**
     * Camelize action name
     *
     * @param $string
     * @return string
     */
    private function camelize($string)
    {
        $stringParts = explode('_', $string);

        $camelized = '';
        foreach ($stringParts as $part) {
            $camelized.= ucfirst($part);
        }

        return $camelized;
    }
}