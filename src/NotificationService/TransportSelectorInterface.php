<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

interface TransportSelectorInterface
{
    public function select(string $channel): TransportInterface;
}