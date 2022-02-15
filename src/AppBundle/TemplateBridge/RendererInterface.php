<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\TemplateBridge;

interface RendererInterface
{
    public function render(string $slug, array $variables): string;
}

