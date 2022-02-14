<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template as EntityTemplate;

interface TemplateRepositoryInterface
{
    /**
     * @throws TemplateNotFoundException
     */
    public function getBySlug(string $slug): EntityTemplate;
}