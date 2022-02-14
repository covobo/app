<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;

final class Verifier
{
    public function __construct(
        private VerificationRepositoryInterface $repository,
        private VerificationCodeGeneratorInterface $codeGenerator
    )
    {
    }

    /**
     * @throws DuplicateNonConfirmedVerifications
     */
    public function create(Subject $subject, string $code): void
    {
        $verification = new Verification($subject, $this->codeGenerator->generate());
        $this->repository->save($verification);
    }

    /**
     * @throws DuplicateNonConfirmedVerifications
     */
    public function verify(Subject $subject, string $code): void
    {
        $verification = $this->repository->findNonConfirmedForSubject($subject);
        $verification->confirmByCode($code);
    }
}