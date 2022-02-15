<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Notification;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\Uuid;

#[Entity]
class Notification
{
    #[Column(type: 'string'), Id]
    private string $id;
    #[Column(type: 'string')]
    private string $recipient;
    #[Column(type: 'string')]
    private string $channel;
    #[Column(type: 'text')]
    private string $body;
    #[Column(type: 'boolean')]
    private bool $dispatched = false;

    public function __construct(string $recipient, string $channel, string $body)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->recipient = $recipient;
        $this->channel = $channel;
        $this->body = $body;
    }

    public function markDispatched(): void
    {
        if ($this->dispatched) {
            throw new \LogicException();
        }

        $this->dispatched = true;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getChannel(): string
    {
        return $this->channel;
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