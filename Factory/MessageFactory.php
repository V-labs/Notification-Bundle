<?php

namespace Vlabs\NotificationBundle\Factory;

use Vlabs\NotificationBundle\VO\NotificationConfig;
use Symfony\Component\Templating\EngineInterface;

class MessageFactory
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param NotificationConfig $config
     * @return object
     */
    public function createFromConfig(NotificationConfig $config)
    {
        $action = $config->getAction();
        $type = $config->getType();

        $camelizedAction = $this->camelize($action);

        $classNS = sprintf('AppBundle\Notification\%s\%s',
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