<?php

namespace Vlabs\NotificationBundle\Notifier;

use Vlabs\NotificationBundle\Exception\MessageDoesNotSupportAttachments;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\MessageOptions\SwiftMailerOptions;

class SwiftMailerNotifier implements NotifierInterface
{
    const EMAIL_TYPE = 'email';

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $emailSender;

    public function __construct(\Swift_Mailer $mailer, $emailSender)
    {
        $this->mailer = $mailer;
        $this->emailSender = $emailSender;
    }

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        $email = (new \Swift_Message())
            ->setFrom($this->emailSender)
            ->setTo($message->getTo())
            ->setBody($message->getBody(), 'text/html');

        /** @var SwiftMailerOptions $messageOption */
        if ($messageOption = $message->getOptions()) {
            $subject       = $messageOption->getValueForKey(SwiftMailerOptions::SUBJECT);
            $cc            = $messageOption->getValueForKey(SwiftMailerOptions::CC);
            $bcc           = $messageOption->getValueForKey(SwiftMailerOptions::BCC);
            $replyTo       = $messageOption->getValueForKey(SwiftMailerOptions::REPLY_TO);
            $attachments   = $messageOption->getValueForKey(SwiftMailerOptions::ATTACHMENTS);

            if ($subject !== null) {
                $email->setSubject($subject);
            }

            if ($cc !== null) {
                $email->setCc($cc);
            }

            if ($bcc !== null) {
                $email->setBcc($bcc);
            }

            if ($replyTo !== null) {
                $email->setReplyTo($replyTo);
            }

            if ($attachments !== null) {
                try {
                    /** @var array $attachment */
                    foreach ($attachments as $attachment) {
                        $swiftAttachment = new \Swift_Attachment($attachment['content'], $attachment['filename']);
                        $email->attach($swiftAttachment);
                    }
                } catch(MessageDoesNotSupportAttachments $e) {
                    //Fail silently
                }
            }
        }

        $this->mailer->send($email);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::EMAIL_TYPE;
    }
}