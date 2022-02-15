<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification\Events;

use SunFinanceGroup\Notificator\Verification\Subject;

trait VerificationEventTrait
{
    private string $uuid;
    private string $code;
    private Subject $subject;
    private \DateTimeInterface $occurredOn;

    public function __construct(string $uuid, string $code, Subject $subject)
    {
        $this->uuid = $uuid;
        $this->code = $code;
        $this->subject = $subject;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getOccurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }
}