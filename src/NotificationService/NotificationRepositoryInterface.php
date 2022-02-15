<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

use SunFinanceGroup\Notificator\Notification\Notification;

interface NotificationRepositoryInterface
{
    public function get(string $uuid): Notification;
    public function save(Notification $verification): void;
}
