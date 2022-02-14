<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Tests\Unit\TemplateBundle\Controller;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SunFinanceGroup\Notificator\TemplateBundle\Controller\TemplateController;
use SunFinanceGroup\Notificator\TemplateBundle\DTO\TemplateRenderRequest;
use SunFinanceGroup\Notificator\TemplateBundle\Entity\Template;
use SunFinanceGroup\Notificator\TemplateBundle\TemplateNotFoundException;
use SunFinanceGroup\Notificator\TemplateBundle\TemplateRepositoryInterface;
use SunFinanceGroup\Notificator\TemplateService\TemplateRendererInterface;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;

/**
 * @group unit
 * @covers \SunFinanceGroup\Notificator\TemplateBundle\Controller\TemplateController
 */
final class TemplateControllerTest extends TestCase
{
    private const SLUG = '123';
    private const VARIABLES = ['1' => '2'];

    /** @var TemplateRendererInterface&MockObject */
    private TemplateRendererInterface $renderer;
    /** @var TemplateRepositoryInterface&MockObject */
    private TemplateRepositoryInterface $repository;
    private TemplateRenderRequest $request;
    private TemplateController $controller;

    public function testRenderTemplateNotFound(): void
    {
        $this->repository->expects($this->once())
            ->method('getBySlug')
            ->willThrowException(new TemplateNotFoundException());
        $response = $this->controller->render($this->request);
        $this->assertSame(HTTPResponse::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertSame('', $response->getContent());
    }

    public function testRenderSuccess(): void
    {
        $mime = 'some-mime-type';
        $template = new Template($mime,self::SLUG, '');
        $renderedContent = 'rendered content';

        $this->repository->expects($this->once())
            ->method('getBySlug')
            ->with(self::SLUG)
            ->willReturn($template);

        $this->renderer->expects($this->once())
            ->method('render')
            ->with($template)
            ->willReturn('rendered content');

        $response = $this->controller->render($this->request);
        $this->assertSame(HTTPResponse::HTTP_OK, $response->getStatusCode());
        $this->assertSame($renderedContent, $response->getContent());
        $this->assertSame($mime, $response->headers->get('Content-Type'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->renderer = $this->createMock(TemplateRendererInterface::class);
        $this->repository = $this->createMock(TemplateRepositoryInterface::class);
        $this->controller = new TemplateController($this->renderer, $this->repository);
        $this->request = new TemplateRenderRequest(self::SLUG, self::VARIABLES);
    }
}