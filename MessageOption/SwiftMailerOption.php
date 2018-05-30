<?php

namespace Vlabs\NotificationBundle\MessageOption;

class SwiftMailerOption implements MessageOptionInterface
{
    /**
     * @var string|array
     */
    private $additionalTo;

    /**
     * @var string|array
     */
    private $cc;

    /**
     * @var string|array
     */
    private $bcc;

    /**
     * @var string|array
     */
    private $replyTo;

    /**
     * @return array|string
     */
    public function getAdditionalTo()
    {
        return $this->additionalTo;
    }

    /**
     * @param array|string $additionalTo
     *
     * @return SwiftMailerOption
     */
    public function setAdditionalTo($additionalTo)
    {
        $this->additionalTo = $additionalTo;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @param array|string $cc
     *
     * @return SwiftMailerOption
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @param array|string $bcc
     *
     * @return SwiftMailerOption
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param array|string $replyTo
     *
     * @return SwiftMailerOption
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }
}