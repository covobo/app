<?php

namespace SunFinanceGroup\Notificator\App;

use OpenApi\Annotations\Post;
use OpenApi\Annotations\Response;

final class TemplateRenderer
{
    /**
     * @Post(operationId="render-template")
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
    public function render(): \Symfony\Component\HttpFoundation\Response
    {
        return new \Symfony\Component\HttpFoundation\Response('Hello world');
    }
}