<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Template;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\MappedSuperclass;

#[MappedSuperclass]
class Template
{
    #[Column(type: 'string'), Id]
    private string $slug;

    #[Column(type: 'string')]
    private string $content;

    public function __construct(string $slug, string $content)
    {
        $this->slug = $slug;
        $this->content = $content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}