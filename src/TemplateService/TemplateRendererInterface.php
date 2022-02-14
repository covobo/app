<?php

namespace SunFinanceGroup\Notificator\TemplateService;

use SunFinanceGroup\Notificator\Template\Template;

interface TemplateRendererInterface
{
    public function render(Template $template, array $context): string;
}