<?php

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;

interface VerifierInterface
{
    public function create(CreateVerificationRequest $request, string $ip, string $userAgent): VerificationCreated;
}