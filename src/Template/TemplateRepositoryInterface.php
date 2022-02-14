<?php

namespace SunFinanceGroup\Notificator\Template;

interface TemplateRepositoryInterface
{
    public function getBySlug(string $slug);
}