<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateVerificationRequest
{
    /**
     * @Assert\Valid()
     * @Assert\NotBlank()
     */
    private Subject $subject;
}