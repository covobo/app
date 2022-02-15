<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Annotations as OA;

final class TemplateRenderRequest
{
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

    public function __construct(string $slug, array $variables)
    {
        $this->slug = $slug;
        $this->variables = $variables;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string[]
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}