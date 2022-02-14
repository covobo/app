<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

interface VerificationCodeGeneratorInterface
{
    public function generate(): string;
}