<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

interface TransportInterface
{
    public function send(Message $message): void;
}