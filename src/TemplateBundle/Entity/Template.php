<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle\Entity;

use SunFinanceGroup\Notificator\Template\Template as BaseTemplate;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Template extends BaseTemplate
{
}