<?php

namespace Vlabs\NotificationBundle\Notifier;

use Maknz\Slack\Client as SlackClient;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vlabs\NotificationBundle\Message\MessageInterface;

class SlackNotifier implements NotifierInterface
{
    const SLACK_TYPE = 'slack';

    /**
     * @var array
     */
    private $config = [];

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        $this->send($message);
    }

    /**
     * @param MessageInterface $message
     */
    private function send(MessageInterface $message)
    {
        $slackClient = new SlackClient($this->config['app_endpoint']);
        $slackClient->send($message->getBody());
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::SLACK_TYPE;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            "app_endpoint",
        ]);

        $this->config = $resolver->resolve($config);
    }
}