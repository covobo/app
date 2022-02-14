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

    /**
     * @codeCoverageIgnore
     * there is no way to test createTemplate because TemplateWrapper is final
     */
    public function render(Template $template, array $context): string
    {
        $twigTemplate = $this->twig->createTemplate($template->getContent(), $template->getSlug());

        return $twigTemplate->render($context);
    }
}