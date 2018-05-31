<?php

namespace Vlabs\NotificationBundle\MessageOptions;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Vlabs\NotificationBundle\Exception\MessageOptionNotAllowedException;

abstract class AbstractMessageOptions implements MessageOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $availableOptions;

    /**
     * @param string $key
     * @param mixed $value
     *
     * @throws MessageOptionNotAllowedException
     */
    public function validateOption($key, $value)
    {
        $resolver = new OptionsResolver();

        foreach ($this->availableOptions as $availableOptionKey => $availableOptionType) {
            $resolver->setDefined($availableOptionKey);

            if ($availableOptionType !== '*') {
                $resolver->setAllowedTypes($availableOptionKey, $availableOptionType);
            }
        }

        try {
            $resolver->resolve([$key => $value]);
        } catch (\Exception $e) {
            throw new MessageOptionNotAllowedException();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValueForKey($key, $value)
    {
        $this->validateOption($key, $value);
        $this->options[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getValueForKey($key)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : null;
    }
}