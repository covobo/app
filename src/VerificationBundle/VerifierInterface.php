<?php

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\VerificationBundle\DTO\CreateVerificationRequest;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;

interface VerifierInterface
{
    /**
     * @param string[] $userInfo
     */
    public function create(CreateVerificationRequest $request, array $userInfo): VerificationCreated;
}