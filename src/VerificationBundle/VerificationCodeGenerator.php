<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\VerificationService\VerificationCodeGeneratorInterface;

final class VerificationCodeGenerator implements VerificationCodeGeneratorInterface
{
    public function generate(): string
    {
        return substr((string) time(), 0, 8);
    }
}