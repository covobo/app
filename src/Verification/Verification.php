<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification;

use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
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

    public function __construct(Subject $subject, \DateTimeInterface $expiredAt, string $code, UserInfo $userInfo)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->code = $code;
        $this->subject = $subject;
        $this->userInfo = $userInfo;
        $this->expiredAt = $expiredAt;
    }

    public function getId(): string
    {
        return $this->id;
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
            throw new NoPermission();
        }

        if ($this->confirmed) {
            throw new VerificationIsAlreadyConfirmed();
        }

        if ((new \DateTimeImmutable())->getTimestamp() > $this->expiredAt->getTimestamp()) {
            throw new VerificationExpired();
        }

        if ($code !== $this->code) {
            throw new BadVerificationCode();
        }

        $this->confirmed = true;
    }
}