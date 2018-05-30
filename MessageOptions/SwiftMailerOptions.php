<?php

namespace Vlabs\NotificationBundle\MessageOptions;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SwiftMailerOptions extends AbstractMessageOptions
{
    const ADDITIONAL_TO = 'additionalTo';
    const CC            = 'cc';
    const BCC           = 'bcc';
    const REPLY_TO      = 'replyTo';

    /**
     * @var array
     */
    private $availableOptions = [
        self::ADDITIONAL_TO => ['string', 'string[]'],
        self::CC            => ['string', 'string[]'],
        self::BCC           => ['string', 'string[]'],
        self::REPLY_TO      => ['string', 'string[]'],
    ];

    /**
     * @param array $option
     */
    public function validateOption($option)
    {
        $resolver = new OptionsResolver();

        foreach ($this->availableOptions as $availableOptionKey => $availableOptionType) {
            $resolver->setDefined($availableOptionKey);

            if ($availableOptionType !== '*') {
                $resolver->setAllowedTypes($availableOptionKey, $availableOptionType);
            }
        }

        $this->options += $resolver->resolve($option);
    }
}