<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Subject
{
    #[Column(type: 'string')]
    private string $identity;
    #[Column(type: 'string')]
    private string $type;

    public function __construct(string $identity, string $type)
    {
        $this->identity = $identity;
        $this->type = $type;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getType(): string
    {
        return $this->type;
    }
}