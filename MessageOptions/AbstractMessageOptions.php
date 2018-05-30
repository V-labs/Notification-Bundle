<?php

namespace Vlabs\NotificationBundle\MessageOptions;

abstract class AbstractMessageOptions implements MessageOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param array $option
     */
    abstract protected function validateOption($option);

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValueForKey($key, $value)
    {
        $this->validateOption([$key => $value]);
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

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}