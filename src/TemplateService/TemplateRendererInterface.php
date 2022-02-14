<?php

namespace SunFinanceGroup\Notificator\TemplateService;

use SunFinanceGroup\Notificator\Template\TemplateNotFoundException;

interface TemplateRendererInterface
{
    /**
     * @throws TemplateNotFoundException
     */
    public function render(string $slug, array $variables): string;
}