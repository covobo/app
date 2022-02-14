<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use Doctrine\ORM\EntityManagerInterface;
use SunFinanceGroup\Notificator\Template\Template;
use SunFinanceGroup\Notificator\Template\TemplateNotFoundException;
use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template as EntityTemplate;
use SunFinanceGroup\Notificator\Template\TemplateRepositoryInterface;

final class DoctrineTemplateRepositoryAdapter implements TemplateRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getBySlug(string $slug): Template
    {
        $template = $this->em
            ->getRepository(EntityTemplate::class)
            ->find($slug);

        if ($template === null) {
            throw new TemplateNotFoundException();
        }

        return $template;
    }
}