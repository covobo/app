<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;
use SunFinanceGroup\Notificator\Template\TemplateNotFoundException;
use SunFinanceGroup\Notificator\TemplateBundle\DTO\TemplateRenderRequest;
use SunFinanceGroup\Notificator\TemplateBundle\TwigTemplateRendererAdapter;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

final class TemplateController
{
    public function __construct(private TwigTemplateRendererAdapter $renderer)
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
     *     response=500,
     *     description="Internal server errors",
     * )
     *
     * @Response(
     *     response=422,
     *     description="Validation failed: invalid / missing variables supplied.",
     * )
     */
    public function render(TemplateRenderRequest $renderRequest): HTTPResponse
    {
        try {
            $content = $this->renderer->render($renderRequest->getSlug(), $renderRequest->getVariables());
        } catch (TemplateNotFoundException $e) {
            return new HTTPResponse('',HTTPResponse::HTTP_NOT_FOUND);
        }

        return new HTTPResponse($content);
    }
}