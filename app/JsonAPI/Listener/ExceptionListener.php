<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App\JsonAPI\Listener;

use SunFinanceGroup\Notificator\App\JsonAPI\Adapters\Exception\InvalidParametersException;
use SunFinanceGroup\Notificator\App\JsonAPI\Adapters\Exception\MalformedJsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/** @codeCoverageIgnore */
final class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $error = [
            'error' => $exception->getMessage(),
        ];

        $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpExceptionInterface) {
            $httpCode = $exception->getStatusCode();
        }

        if ($exception instanceof InvalidParametersException) {
            $error['debug'] = $exception->getDebug();
            $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        if ($exception instanceof MalformedJsonException) {
            $httpCode = Response::HTTP_BAD_REQUEST;
        }

        $event->allowCustomResponseCode();
        $event->setResponse(new JsonResponse($error, $httpCode));
    }
}
