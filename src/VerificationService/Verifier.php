<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\DuplicateNonConfirmedVerifications;

final class Verifier implements VerifierInterface
{
    public function __construct(
        private VerificationRepositoryInterface $repository,
        private VerificationCodeGeneratorInterface $codeGenerator
    )
    {
    }

    public function createForSubject(Subject $subject, \DateTimeInterface $dateTime, array $userInfo): Verification
    {
        $verification = $this->repository->findNonConfirmedForSubject($subject);

        if ($verification !== null) {
            throw new DuplicateNonConfirmedVerifications('Duplicated verification');
        }

        $verification = new Verification($subject, $dateTime, $this->codeGenerator->generate(), $userInfo);
        $this->repository->save($verification);

        return $verification;
    }

    public function confirm(Verification $verification, string $code): void
    {
        $verification->confirmByCode($code);

    }
}