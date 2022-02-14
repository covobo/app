<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\VerificationRepositoryInterface;

final class DoctrineVerificationRepositoryAdapter implements VerificationRepositoryInterface
{
    public function getNonConfirmedForSubject(Subject $subject): Verification
    {
        return new Verification($subject, '123');
    }

    public function save(Verification $verification): void
    {
        // TODO: Implement save() method.
    }
}