<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification;

use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use SunFinanceGroup\Notificator\Verification\Events\VerificationConfirmationFailed;
use SunFinanceGroup\Notificator\Verification\Events\VerificationConfirmed;
use SunFinanceGroup\Notificator\Verification\Events\VerificationCreated;
use SunFinanceGroup\Notificator\Verification\Events\VerificationEvent;
use SunFinanceGroup\Notificator\Verification\Exception\NoPermission;
use SunFinanceGroup\Notificator\Verification\Exception\VerificationExpired;
use SunFinanceGroup\Notificator\Verification\Exception\VerificationIsAlreadyConfirmed;

#[Entity]
class Verification
{
    #[Column(type: 'string'), Id]
    private string $id;
    #[Column(type: 'string')]
    private string $code;
    #[Column(type: 'boolean')]
    private bool $confirmed = false;
    #[Embedded(class: Subject::class, columnPrefix: 'subject_')]
    private Subject $subject;
    #[Column(type: 'datetime')]
    private \DateTimeInterface $expiredAt;
    #[Embedded(class: UserInfo::class, columnPrefix: 'user_info_')]
    private UserInfo $userInfo;
    #[Column(type: 'integer')]
    private int $maxAttempts;
    #[Column(type: 'integer')]
    private int $attempts = 0;
    /** @var VerificationEvent[] */
    private array $events;

    public function __construct(
        Subject $subject,
        \DateTimeInterface $expiredAt,
        string $code,
        UserInfo $userInfo,
        int $maxAttempts
    )
    {
        $this->id = Uuid::uuid4()->toString();
        $this->code = $code;
        $this->subject = $subject;
        $this->userInfo = $userInfo;
        $this->expiredAt = $expiredAt;
        $this->maxAttempts = $maxAttempts;
        $this->events[] = new VerificationCreated($this->id, $this->code, $this->subject);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function incrementAttempts(): void
    {
        $this->attempts++;
    }

    /**
     * @throws BadVerificationCode
     * @throws VerificationIsAlreadyConfirmed
     * @throws VerificationExpired
     * @throws NoPermission
     */
    public function confirmByCodeAndUserInfo(string $code, UserInfo $userInfo): void
    {
        if (!$this->userInfo->equals($userInfo)) {
            $this->events[] = new VerificationConfirmationFailed($this->id, $this->code, $this->subject);

            throw new NoPermission();
        }

        if ($this->confirmed) {
            $this->events[] = new VerificationConfirmationFailed($this->id, $this->code, $this->subject);

            throw new VerificationIsAlreadyConfirmed();
        }

        if ((new \DateTimeImmutable())->getTimestamp() > $this->expiredAt->getTimestamp()) {
            $this->events[] = new VerificationConfirmationFailed($this->id, $this->code, $this->subject);

            throw new VerificationExpired();
        }

        if ($this->attempts > $this->maxAttempts) {
            $this->events[] = new VerificationConfirmationFailed($this->id, $this->code, $this->subject);

            throw new VerificationExpired();
        }

        if ($code !== $this->code) {
            $this->events[] = new VerificationConfirmationFailed($this->id, $this->code, $this->subject);

            throw new BadVerificationCode();
        }

        $this->confirmed = true;

        $this->events[] = new VerificationConfirmed($this->id, $this->code, $this->subject);
    }

    /**
     * @return VerificationEvent[]
     */
    public function flushEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}