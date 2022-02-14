<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Tests\Unit\Template;

use PHPUnit\Framework\TestCase;
use SunFinanceGroup\Notificator\Template\Template;

/**
 * @group unit
 * @covers \SunFinanceGroup\Notificator\Template\Template
 */
final class TemplateTest extends TestCase
{
    private const SLUG = 'slug';
    private const CONTENT = 'content';

    public function testAccessors(): void
    {
        $template = new Template(self::SLUG, self::CONTENT);
        $this->assertSame(self::SLUG, $template->getSlug());
        $this->assertSame(self::CONTENT, $template->getContent());
    }
}