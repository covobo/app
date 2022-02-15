<?php

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\DuplicateNonConfirmedVerifications;

interface VerifierInterface
{
    /**
     * @param string[] $userInfo
     *
     * @throws DuplicateNonConfirmedVerifications
     */
    public function createForSubject(Subject $subject, \DateTimeInterface $dateTime, array $userInfo): Verification;

    public function confirm(Verification $verification, string $code): void;
}