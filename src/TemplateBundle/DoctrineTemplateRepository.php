<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use Doctrine\ORM\EntityManagerInterface;
use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template as EntityTemplate;

final class DoctrineTemplateRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getBySlug(string $slug): EntityTemplate
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