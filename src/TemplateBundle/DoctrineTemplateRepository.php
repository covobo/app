<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\TemplateBundle;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template as EntityTemplate;

final class DoctrineTemplateRepository implements TemplateRepositoryInterface
{
    private ObjectRepository $doctrineRepo;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->doctrineRepo = $this->em->getRepository(EntityTemplate::class);
    }

    public function getBySlug(string $slug): EntityTemplate
    {
        $template = $this->doctrineRepo->find($slug);

        if ($template === null) {
            throw new TemplateNotFoundException();
        }

        return $template;
    }
}