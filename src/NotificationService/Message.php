<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\NotificationService;

final class Message
{
    public function __construct(private string $recipient, private string $body)
    {
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}