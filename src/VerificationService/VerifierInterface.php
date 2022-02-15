<?php

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\UserInfo;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\DuplicateNonConfirmedVerifications;

interface VerifierInterface
{
    /**
     * @throws DuplicateNonConfirmedVerifications
     */
    public function createForSubject(Subject $subject, UserInfo $userInfo): Verification;

    public function confirm(string $uuid, string $code, UserInfo $userInfo): void;
}