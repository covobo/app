<?php

namespace SunFinanceGroup\Notificator\Template;

interface TemplateRepositoryInterface
{
    /**
     * @throws TemplateNotFoundException
     */
    public function getBySlug(string $slug): Template;
}