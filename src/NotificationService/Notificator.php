<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

use SunFinanceGroup\Notificator\Notification\Notification;

final class Notificator implements NotificatorInterface
{
    public function __construct(private TransportSelectorInterface $selector, private NotificationRepositoryInterface $repository)
    {
    }

    public function sendNotification(Notification $notification): void
    {
        $message = new Message($notification->getRecipient(), $notification->getBody());

        $this->selector->select($notification->getChannel())->send($message);

        $notification->markDispatched();

        $this->repository->save($notification);
    }
}

