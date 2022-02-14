<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Tests\Unit\TemplateBundle\DTO;

use PHPUnit\Framework\TestCase;
use SunFinanceGroup\Notificator\TemplateBundle\DTO\TemplateRenderRequest;

/**
 * @group unit
 * @covers \SunFinanceGroup\Notificator\TemplateBundle\DTO\TemplateRenderRequest
 */
final class TemplateRenderRequestTest extends TestCase
{
    private const SLUG = 'slug';
    private const VARIABLES = ['1' => '2'];

    public function testAccessors(): void
    {
        $template = new TemplateRenderRequest(self::SLUG, self::VARIABLES);
        $this->assertSame(self::SLUG, $template->getSlug());
        $this->assertSame(self::VARIABLES, $template->getVariables());
    }
}