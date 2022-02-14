<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\JsonAPI\Adapters\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/** @codeCoverageIgnore */
final class MalformedJsonException extends BadRequestHttpException
{
    /** @codeCoverageIgnore */
    public static function create(string $message, ?\Throwable $previous = null): self
    {
        return new self($message, $previous);
    }
}
