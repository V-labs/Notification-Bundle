<?php

namespace Vlabs\NotificationBundle\Notifier;

use Ovh\Sms\SmsApi;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\MessageOptions\OvhSmsOptions;

class OvhSmsNotifier implements NotifierInterface
{
    const SMS_TYPE = 'sms';

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $endpoint = 'ovh-eu';

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        $this->send($message);
    }

    private function send(MessageInterface $message)
    {
        $sms = new SmsApi(
            $this->config['app_key'],
            $this->config['app_secret'],
            $this->endpoint,
            $this->config['consumer_key']
        );

        /** @var array $accounts */
        $accounts = $sms->getAccounts();

        $sms->setAccount(array_shift($accounts));

        $smsMessage = $sms->createMessage(false);

        // FluentInterface pleaaase
        $smsMessage->addReceiver($message->getTo());
        $smsMessage->setIsMarketing(false);

        if ($messageOption = $message->getOptions()) {
            $sender = $messageOption->getValueForKey(OvhSmsOptions::SENDER);

            if ($sender !== null) {
                $smsMessage->setSender($sender);
            }
        }

        if ($this->config['disable_sending']) {
            $smsMessage->send($message->getBody());
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::SMS_TYPE;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired([
            "app_key",
            "app_secret",
            "consumer_key",
            "disable_sending"
        ]);

        $this->config = $resolver->resolve($config);
    }
}