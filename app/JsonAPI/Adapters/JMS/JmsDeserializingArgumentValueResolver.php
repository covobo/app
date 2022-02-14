<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\JsonAPI\Adapters\JMS;

use JMS\Serializer\Exception\NonCastableTypeException;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Exception\ValidationFailedException;
use JMS\Serializer\SerializerInterface;
use Metadata\MetadataFactoryInterface;
use SunFinanceGroup\Notificator\App\JsonApi\Adapters\Exception\InvalidParametersException;
use SunFinanceGroup\Notificator\App\JsonAPI\Adapters\Exception\MalformedJsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** @codeCoverageIgnore */
final class JmsDeserializingArgumentValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private MetadataFactoryInterface $metadataFactory,
        private ValidatorInterface $validator
    )
    {
    }

    /**
     * @return iterable<mixed>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $value = $this->doDeserialize((string) $request->getContent(), $argument, );

        if ($argument->isVariadic()) {
            return yield from $value;
        }

        return yield $value;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $type = $argument->getType();

        return is_string($type) && class_exists($type) && $this->metadataFactory->getMetadataForClass($type) !== null;
    }

    private function doDeserialize(string $content, ArgumentMetadata $argument): mixed
    {
        try {
            $type = $argument->getType();
            if ($argument->isVariadic()) {
                $type .= '[]';
            }

            /** @var class-string $type */
            $deserialized = $this->serializer->deserialize($content, $type, 'json');

            $violations = $this->validator->validate($deserialized);

            if ($violations->count() > 0) {
                throw InvalidParametersException::fromNestedViolationList(
                    $argument->getName(),
                    $violations,
                    null
                );
            }

            return $deserialized;
        } catch (NonCastableTypeException | \JsonException $exception) {
            throw new InvalidParametersException($exception->getMessage(), $exception);
        } catch (RuntimeException $exception) {
            throw MalformedJsonException::create('Malformed json', $exception);
        }
    }
}
