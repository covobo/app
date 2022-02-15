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
    public function createForSubject(Subject $subject, array $userInfo): Verification;

    public function confirm(string $uuid, string $code): void;
}