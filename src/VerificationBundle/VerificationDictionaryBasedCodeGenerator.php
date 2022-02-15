<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use SunFinanceGroup\Notificator\VerificationService\VerificationCodeGeneratorInterface;

final class VerificationDictionaryBasedCodeGenerator implements VerificationCodeGeneratorInterface
{
    public function __construct(private int $codeLength, private array $dict)
    {
        if ($this->codeLength <= 0) {
            throw new \InvalidArgumentException('Code length must be greater then 0');
        }

        if (count($this->dict) === 0) {
            throw new \InvalidArgumentException('An empty dict is passed');
        }
    }

    public function generate(): string
    {
        $code = '';
        $dictRange = count($this->dict) - 1;

        do {
            $code .= $this->dict[random_int(0, $dictRange)];
        } while (strlen($code) !== $this->codeLength);

        return $code;
    }
}