<?php

namespace Vlabs\NotificationBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Vlabs\NotificationBundle\VO\NotificationConfig;
use Symfony\Component\Templating\EngineInterface;

class MessageFactory
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var string
     */
    protected $rootNamespace;

    public function __construct(EngineInterface $templating, TranslatorInterface $translator, $rootNamespace)
    {
        $this->templating    = $templating;
        $this->translator    = $translator;
        $this->rootNamespace = $rootNamespace;
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

        $classNS = sprintf('%s\%s\%s',
            $this->rootNamespace,
            ucfirst($type),
            $camelizedAction
        );

        $reflectedMessage = new \ReflectionClass($classNS);

        return $reflectedMessage->newInstance($config, $this->templating, $this->translator);
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