<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\TemplateBridge;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

final class Renderer implements RendererInterface
{
    public function __construct(private ClientInterface $guzzle)
    {
    }

    public function render(string $slug, array $variables): string
    {
        $response = $this->guzzle->request(
            'POST',
            '/templates/render',
            [
                RequestOptions::JSON => [
                    'slug' => $slug,
                    'variables' => $variables
                ]
            ]
        );

        return $response->getBody()->getContents();
    }
}