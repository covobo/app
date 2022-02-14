<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\JsonAPI\Adapters\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/** @codeCoverageIgnore */
final class InvalidParametersException extends BadRequestHttpException
{
    /** @var mixed[] */
    private array $debug = [];

    /** @codeCoverageIgnore */
    public static function create(string $message, ?\Throwable $previous = null): self
    {
        return new self($message, $previous);
    }

    /**
     * @param ConstraintViolationListInterface<ConstraintViolation> $list
     */
    public static function fromNestedViolationList(string $nestedParameter, ConstraintViolationListInterface $list, ?\Throwable $previous): self
    {
        $data = [];
        foreach ($list as $index => $error) {
            $name = $error->getPropertyPath() ?: $index;
            $data[$nestedParameter . '.' . $name] = $error->getMessage();
        }

        $exception = self::create('Parameters validation failed.', $previous);

        $exception->debug = $data;
        return $exception;
    }

    public function getDebug(): array
    {
        return $this->debug;
    }
}
