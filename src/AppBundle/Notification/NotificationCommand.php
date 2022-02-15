<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

final class NotificationCommand
{
    public function __construct(private string $uuid)
    {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}