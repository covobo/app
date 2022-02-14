<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle\Entity;

use Doctrine\ORM\Mapping\Column;
use SunFinanceGroup\Notificator\Template\Template as BaseTemplate;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Template extends BaseTemplate
{
    #[Column(type: 'string')]
    private string $mime;

    public function getMime(): string
    {
        return $this->mime;
    }
}