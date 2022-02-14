<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use SunFinanceGroup\Notificator\Template\TemplateRepositoryInterface;
use SunFinanceGroup\Notificator\TemplateService\TemplateRendererInterface;
use Twig\Environment;

final class TwigTemplateRendererAdapter implements TemplateRendererInterface
{
    public function __construct(private TemplateRepositoryInterface $repository, private Environment $twig)
    {
    }

    public function render(string $slug, array $variables): string
    {
        $template = $this->repository->getBySlug($slug);

        $content = $this->twig->createTemplate($template->getContent(), $template->getSlug());

        return $content->render($variables);
    }
}