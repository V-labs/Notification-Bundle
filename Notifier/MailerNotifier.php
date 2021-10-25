<?php

namespace Vlabs\NotificationBundle\Notifier;

use Soundasleep\Html2Text;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Vlabs\NotificationBundle\Message\MessageInterface;
use Vlabs\NotificationBundle\MessageOptions\MailerOptions;

class MailerNotifier implements NotifierInterface
{
    const EMAIL_TYPE = 'email';

    /** @var MailerInterface */
    protected $mailer;

    /** @var string */
    protected $defaultFromEmail;

    /** @var string */
    protected $defaultFromName;

    /**
     * MailerNotifier constructor.
     *
     * @param MailerInterface $mailer
     * @param                 $defaultFromEmail
     * @param                 $defaultFromName
     */
    public function __construct(MailerInterface $mailer, $defaultFromEmail, $defaultFromName)
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
        $email = (new Email())
            ->to(...(is_array($message->getTo())
                ? $message->getTo()
                : [$message->getTo()]))
            ->text(@Html2Text::convert($message->getBody(), [
                'ignore_errors' => true
            ]))
            ->html($message->getBody());

        /** @var MailerOptions $messageOption */
        if ($messageOption = $message->getOptions()) {
            $fromEmail     = $messageOption->getValueForKey(MailerOptions::FROM_EMAIL);
            $fromName      = $messageOption->getValueForKey(MailerOptions::FROM_NAME);
            $subject       = $messageOption->getValueForKey(MailerOptions::SUBJECT);
            $cc            = $messageOption->getValueForKey(MailerOptions::CC);
            $bcc           = $messageOption->getValueForKey(MailerOptions::BCC);
            $replyTo       = $messageOption->getValueForKey(MailerOptions::REPLY_TO);
            $attachments   = $messageOption->getValueForKey(MailerOptions::ATTACHMENTS);

            if ($subject !== null) {
                $email->subject($subject);
            }

            if ($cc !== null) {
                $email->cc(...(is_array($cc) ? $cc : [$cc]));
            }

            if ($bcc !== null) {
                $email->bcc(...(is_array($bcc) ? $bcc : [$bcc]));
            }

            if ($replyTo !== null) {
                $email->replyTo(...(is_array($replyTo) ? $replyTo : [$replyTo]));
            }

            if ($attachments !== null) {
                /** @var array $attachment */
                foreach ($attachments as $attachment) {
                    $email->attach($attachment['content'], $attachment['filename']);
                }
            }
        }

        $fromEmail = $fromEmail ?? $this->defaultFromEmail;

        $email->from(new Address(
            $fromEmail,
            $fromName ?? $this->defaultFromName
        ));

        // Split email address : left part of @ and right part, used for Message-ID header
        preg_match('/([^@]+)@([^@]+)$/u', $fromEmail, $fromEmailInformation);
        $username = $fromEmailInformation[1] ?? 'notification-bundle';
        $domain   = $fromEmailInformation[2] ?? 'vlabs.fr';

        $emailHeaders = $email->getHeaders();
        $emailHeaders->addIdHeader('Message-ID', time() . '.' . uniqid($username) . '@' . $domain);
        $emailHeaders->addTextHeader('X-Mailer', 'PHP v' . phpversion());

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