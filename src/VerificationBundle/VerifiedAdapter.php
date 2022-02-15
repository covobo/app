<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;
use SunFinanceGroup\Notificator\VerificationService\Verifier as AppVerifier;

final class VerifiedAdapter implements VerifierInterface
{
    public function __construct(private AppVerifier $adaptee)
    {
    }

    public function create(CreateVerificationRequest $request, array $userInfo): VerificationCreated
    {
        $subjectDTO = $request->getSubject();

        $newVerification = $this->adaptee->createForSubject(
            new Subject(
                $subjectDTO->getIdentity(),
                $subjectDTO->getType()
            ),
            $userInfo
        );

        return new VerificationCreated($newVerification->getId());
    }

    public function confirm(string $uuid, string $code): void
    {
        $this->adaptee->confirm($uuid, $code);
    }
}