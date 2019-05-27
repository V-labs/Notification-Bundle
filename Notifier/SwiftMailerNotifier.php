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
    protected $defaultFromEmail;

    /**
     * @var string
     */
    protected $defaultFromName;

    /**
     * SwiftMailerNotifier constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param               $defaultFromEmail
     * @param               $defaultFromName
     */
    public function __construct(\Swift_Mailer $mailer, $defaultFromEmail, $defaultFromName)
    {
        $this->mailer           = $mailer;
        $this->defaultFromEmail = $defaultFromEmail;
        $this->defaultFromName  = $defaultFromName;
    }

    /**
     * @param MessageInterface $message
     */
    public function addToQueue(MessageInterface $message)
    {
        $email = (new \Swift_Message())
            ->setTo($message->getTo())
            ->setBody($message->getBody(), 'text/html');

        /** @var SwiftMailerOptions $messageOption */
        if ($messageOption = $message->getOptions()) {
            $fromEmail     = $messageOption->getValueForKey(SwiftMailerOptions::FROM_EMAIL);
            $fromName      = $messageOption->getValueForKey(SwiftMailerOptions::FROM_NAME);
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

        $email->setFrom(
            isset($fromEmail) ? $fromEmail : $this->defaultFromEmail,
            isset($fromName)  ? $fromName  : $this->defaultFromName
        );

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