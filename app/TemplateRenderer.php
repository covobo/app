<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;
use SunFinanceGroup\Notificator\App\DTO\TemplateRenderRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class TemplateRenderer
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * @Post(
     *     operationId="render-template",
     *     @RequestBody(
     *          @MediaType(
     *              mediaType="application/json",
     *              @Schema(ref=@Model(type=TemplateRenderRequest::class))
     *          )
     *     )
     * )
     *
     * @Response(
     *     response=200,
     *     description="Template rendered."
     * )
     *
     * @Response(
     *     response=400,
     *     description="Malformed JSON passed.",
     * )
     *
     * @Response(
     *     response=404,
     *     description="Template not found.",
     * )
     *
     * @Response(
     *     response=422,
     *     description="Validation failed: invalid / missing variables supplied.",
     * )
     */
    public function render(TemplateRenderRequest $renderRequest): \Symfony\Component\HttpFoundation\Response
    {
        return new \Symfony\Component\HttpFoundation\Response('Hello world');
    }
}