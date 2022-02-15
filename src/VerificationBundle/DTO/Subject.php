<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

final class Subject
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max=255)
     * @OA\Property(
     *     type="string",
     *     description="Destination for verification.",
     *     example="john.doe@abc.xyz"
     * )
     */
    #[Serializer\Type(name: "string")]
    private ?string $identity;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(max=255)
     * @OA\Property(
     *     type="string",
     *     description="The unique identifier of the template.",
     *     example="mobile-verfication"
     * )
     */
    #[Serializer\Type(name: "string")]
    private ?string $type;

    public function __construct(string $identity, string $type)
    {
        $this->identity = $identity;
        $this->type = $type;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getType(): string
    {
        return $this->type;
    }
}