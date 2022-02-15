<?php

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;

interface VerifierInterface
{
    /**
     * @param string[] $userInfo
     *
     * @throws DuplicateNonConfirmedVerifications
     */
    public function createForSubject(Subject $subject, array $userInfo): Verification;

    /**
     * @throws MultipleVerificationExists
     */
    public function verifyForSubject(Subject $subject, string $code): void;
}