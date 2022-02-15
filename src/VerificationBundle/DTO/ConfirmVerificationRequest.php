<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

final class ConfirmVerificationRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max=255)
     * @OA\Property(
     *     type="string",
     *     description="Verification code.",
     *     example="12345678"
     * )
     */
    #[Serializer\Type(name: "string")]
    private ?string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}