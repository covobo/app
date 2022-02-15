<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

use SunFinanceGroup\Notificator\Notification\Notification;

interface NotificatorInterface
{
    public function sendNotification(Notification $notification): void;
}