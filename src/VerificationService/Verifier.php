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
        private VerificationCodeGeneratorInterface $codeGenerator,
        private int $ttlMinutes
    )
    {
    }

    public function createForSubject(Subject $subject, array $userInfo): Verification
    {
        $verification = $this->repository->findNonConfirmedForSubject($subject);

        if ($verification !== null) {
            throw new DuplicateNonConfirmedVerifications('Duplicated verification');
        }

        $expiredAt = (new \DateTime())->modify(sprintf('+%dminutes', $this->ttlMinutes));

        $verification = new Verification(
            $subject,
            $expiredAt,
            $this->codeGenerator->generate(),
            $userInfo
        );

        $this->repository->save($verification);

        return $verification;
    }

    public function confirm(string $uuid, string $code): void
    {
        $verification = $this->repository->get($uuid);
        $verification->confirmByCode($code);
        $this->repository->save($verification);
    }
}