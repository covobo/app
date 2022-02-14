<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Post;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;
use SunFinanceGroup\Notificator\TemplateBundle\DoctrineTemplateRepository;
use SunFinanceGroup\Notificator\TemplateBundle\DTO\TemplateRenderRequest;
use SunFinanceGroup\Notificator\TemplateBundle\TemplateNotFoundException;
use SunFinanceGroup\Notificator\TemplateBundle\TwigTemplateRendererAdapter;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

final class TemplateController
{
    public function __construct(private TwigTemplateRendererAdapter $renderer, private DoctrineTemplateRepository $repository)
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
            $template = $this->repository->getBySlug($renderRequest->getSlug());
        } catch (TemplateNotFoundException $e) {
            return new HTTPResponse('',HTTPResponse::HTTP_NOT_FOUND);
        }

        return new HTTPResponse(
            $this->renderer->render($template, $renderRequest->getVariables()),
            HTTPResponse::HTTP_OK,
            [
                'Content-Type' => $template->getMime()
            ]
        );
    }
}