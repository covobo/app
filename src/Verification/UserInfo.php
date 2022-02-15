<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\Verification;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class UserInfo
{
    #[Column(type: 'string')]
    private string $ip;
    #[Column(type: 'string')]
    private string $userAgent;

    public function __construct(string $ip, string $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function equals(UserInfo $userInfo)
    {
        return $this->getIp() === $userInfo->getIp()
            && strtolower($this->getUserAgent()) === strtolower($userInfo->getUserAgent());
    }
}