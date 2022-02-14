<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\JsonAPI\Adapters\JMS;

use JMS\Serializer\SerializerInterface;
use Metadata\MetadataFactoryInterface;
use SunFinanceGroup\Notificator\VerificationBundle\DTO\VerificationCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/** @codeCoverageIgnore  */
final class JmsResponseSerializer implements EventSubscriberInterface
{
    private SerializerInterface $serializer;
    private MetadataFactoryInterface $metadataFactory;

    public function __construct(SerializerInterface $serializer, MetadataFactoryInterface $metadataFactory)
    {
        $this->serializer = $serializer;
        $this->metadataFactory = $metadataFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'onResponse',
        ];
    }

    public function onResponse(ViewEvent $event): void
    {
        $result = $event->getControllerResult();
        if ($result instanceof Response) {
            return;
        }

        if ($result === null) {
            $event->setResponse(new JsonResponse('', Response::HTTP_OK, [], true));

            return;
        }

        if (!$this->isSerializableResponse($result)) {
            return;
        }

        if ($result instanceof \Traversable) {
            $result = iterator_to_array($result);
        }

        $responseCode = Response::HTTP_OK;

        if ($result instanceof VerificationCreated) {
            $responseCode = Response::HTTP_CREATED;
        }

        $response = new JsonResponse($this->serializer->serialize($result, 'json'), $responseCode, [], true);

        $event->setResponse($response);
    }

    private function isSerializableResponse(mixed $result): bool
    {
        if (!is_object($result)) {
            return false;
        }

        return $this->metadataFactory->getMetadataForClass(get_class($result)) !== null;
    }
}
