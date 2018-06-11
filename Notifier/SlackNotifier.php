<?php

namespace Vlabs\NotificationBundle\Notifier;

use GuzzleHttp\Client;
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
        /** @var Client $slackClient */
        $slackClient = new Client();
        $slackClient->post($this->config['app_endpoint'], [
            'body'    => json_encode(['text' => $message->getBody()]),
            'headers' => ['Content-type' => 'application/json']
        ]);
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