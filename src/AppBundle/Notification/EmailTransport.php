<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use SunFinanceGroup\Notificator\NotificationService\Message;
use SunFinanceGroup\Notificator\NotificationService\TransportInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class EmailTransport implements TransportInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(Message $message): void
    {
        $email = (new Email())
            ->from('covobo@me.com')
            ->to($message->getRecipient())
            ->subject('Notification')
            ->html($message->getBody());

        $this->mailer->send($email);
    }
}