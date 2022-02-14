<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

final class TemplateRenderRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @OA\Property(
     *     type="string",
     *     description="The unique identifier of the template.",
     *     example="mobile-verfication"
     * )
     */
    #[Serializer\Type(name: "string")]
    private ?string $slug;

    /**
     * @OA\Property(
     *     type="object",
     *     description="code:stringValue",
     *     example={"code": "1234"}
     * )
     * @var array<string, string>
     */
    #[Serializer\Type(name: "array<string, string>")]
    private array $variables;
}