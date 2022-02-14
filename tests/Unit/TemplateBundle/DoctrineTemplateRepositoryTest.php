<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Tests\Unit\TemplateBundle;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SunFinanceGroup\Notificator\TemplateBundle\DoctrineTemplateRepository;
use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template as EntityTemplate;
use SunFinanceGroup\Notificator\TemplateBundle\TemplateNotFoundException;

/**
 * @group unit
 * @covers \SunFinanceGroup\Notificator\TemplateBundle\DoctrineTemplateRepository
 */
final class DoctrineTemplateRepositoryTest extends TestCase
{
    /** @var ObjectRepository&MockObject */
    private ObjectRepository $innerRepo;
    private DoctrineTemplateRepository $repository;

    private const SLUG = 'slug';

    public function testGetBySlugNotFound(): void
    {
        $this->innerRepo->expects($this->once())
            ->method('find')
            ->with(self::SLUG)
            ->willReturn(null);

        $this->expectException(TemplateNotFoundException::class);
        $this->repository->getBySlug(self::SLUG);
    }

    public function testGetBySlugSuccess(): void
    {
        $template = new EntityTemplate('mime', self::SLUG, '');
        $this->innerRepo->expects($this->once())
            ->method('find')
            ->with(self::SLUG)
            ->willReturn($template);

        self::assertSame($template, $this->repository->getBySlug(self::SLUG));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->innerRepo = $this->createMock(ObjectRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())
            ->method('getRepository')
            ->with(EntityTemplate::class)
            ->willReturn($this->innerRepo);

        $this->repository = new DoctrineTemplateRepository($em);
    }
}