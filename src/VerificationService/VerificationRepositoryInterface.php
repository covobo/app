<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\MultipleVerificationExists;
use SunFinanceGroup\Notificator\VerificationService\Exception\VerificationNotFoundException;

interface VerificationRepositoryInterface
{
    /**
     * @throws MultipleVerificationExists
     */
    public function findNonConfirmedForSubject(Subject $subject): ?Verification;

    public function save(Verification $verification): void;

    /**
     * @throws VerificationNotFoundException
     */
    public function get(string $uuid): Verification;
}