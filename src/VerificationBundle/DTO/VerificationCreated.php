<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle\DTO;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;

final class VerificationCreated
{
    /**
     * @OA\Property(
     *     type="string",
     *     description="Created verification id.",
     *     example="b249b759-11a7-4b8b-a38d-e53d193d4e90"
     * )
     */
    #[Serializer\Type(name: "string")]
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}