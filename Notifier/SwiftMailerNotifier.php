<?php

namespace Vlabs\NotificationBundle\Notifier;

use Vlabs\NotificationBundle\Exception\MessageDoesNotSupportAttachments;
use Vlabs\NotificationBundle\Message\MessageInterface;

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
            ->setSubject($message->getSubject())
            ->setFrom($this->emailSender)
            ->setTo($message->getTo())
            ->setBody($message->getBody(), 'text/html');

        try{
            $attachments = $message->getAttachments();

            /** @var array $attachment */
            foreach ($attachments as $attachment)
            {
                $swiftAttachment = new \Swift_Attachment($attachment['content'], $attachment['filename']);

                $email->attach($swiftAttachment);
            }
        }catch(MessageDoesNotSupportAttachments $e){
            //Fail silently
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