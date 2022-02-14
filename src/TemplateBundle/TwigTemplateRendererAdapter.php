<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use SunFinanceGroup\Notificator\Template\Template;
use SunFinanceGroup\Notificator\TemplateService\TemplateRendererInterface;
use Twig\Environment;

final class TwigTemplateRendererAdapter implements TemplateRendererInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function render(Template $template, array $context): string
    {
        $content = $this->twig->createTemplate($template->getContent(), $template->getSlug());

        return $content->render($context);
    }
}