<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\UserInfo;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;
use SunFinanceGroup\Notificator\VerificationService\Verifier as AppVerifier;

final class VerifiedAdapter implements VerifierInterface
{
    public function __construct(private AppVerifier $adaptee)
    {
    }

    public function create(CreateVerificationRequest $request, string $ip, string $userAgent): VerificationCreated
    {
        $subjectDTO = $request->getSubject();

        $newVerification = $this->adaptee->createForSubject(
            new Subject(
                $subjectDTO->getIdentity(),
                $subjectDTO->getType()
            ),
            new UserInfo(
                $ip,
                $userAgent
            )
        );

        return new VerificationCreated($newVerification->getId());
    }

    public function confirm(string $uuid, string $code, string $ip, string $userAgent): void
    {
        $this->adaptee->confirm(
            $uuid,
            $code,
            new UserInfo($ip, $userAgent)
        );
    }
}