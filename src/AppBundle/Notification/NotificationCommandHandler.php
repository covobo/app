<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use SunFinanceGroup\Notificator\NotificationService\NotificatorInterface;
use SunFinanceGroup\Notificator\NotificationService\NotificationRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class NotificationCommandHandler
{
    public function __construct(private NotificationRepositoryInterface $repository, private NotificatorInterface $notificator)
    {
    }

    public function __invoke(NotificationCommand $command)
    {
        $notification = $this->repository->get($command->getUuid());
        $this->notificator->sendNotification($notification);
    }
}