<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;

interface VerificationRepositoryInterface
{
    /**
     * @throws
     */
    public function getNonConfirmedForSubject(Subject $subject): Verification;

    public function save(Verification $verification): void;
}