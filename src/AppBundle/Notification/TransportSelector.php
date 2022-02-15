<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use SunFinanceGroup\Notificator\NotificationService\TransportInterface;
use SunFinanceGroup\Notificator\NotificationService\TransportSelectorInterface;

final class TransportSelector implements TransportSelectorInterface
{
    /** @var array<string, TransportInterface> */
    private array $transportMap;

    public function __construct(private array $transportsMap = [])
    {
    }

    public function registerTransport(string $channel, TransportInterface $transport): void
    {
        $this->transportMap[$channel] = $transport;
    }

    public function select(string $channel): TransportInterface
    {
        if (!isset($this->transportMap[$channel])) {
            throw new \RuntimeException(sprintf('Transport for channel %s is not configured', $channel));
        }

        return $this->transportMap[$channel];
    }
}