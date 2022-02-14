<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification;

use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

#[MappedSuperclass]
class Verification
{
    #[Column(type: 'string'), Id]
    private string $id;
    #[Column(type: 'string')]
    private string $code;
    #[Column(type: 'bool')]
    private bool $confirmed = false;
    #[Embedded(class: Subject::class, columnPrefix: 'subject_')]
    private Subject $subject;
    private \DateTimeInterface $createdAt;

    public function __construct(Subject $subject, string $code)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->code = $code;
        $this->subject = $subject;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @throws BadVerificationCode
     * @throws VerificationIsAlreadyConfirmed
     */
    public function confirmByCode(string $code): void
    {
        if ($this->confirmed) {
            throw new VerificationIsAlreadyConfirmed();
        }

        if ($code !== $this->code) {
            throw new BadVerificationCode();
        }

        $this->confirmed = true;
    }
}