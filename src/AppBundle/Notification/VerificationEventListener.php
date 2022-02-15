<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use SunFinanceGroup\Notificator\AppBundle\TemplateBridge\RendererInterface;
use SunFinanceGroup\Notificator\Notification\Notification;
use SunFinanceGroup\Notificator\NotificationService\NotificationRepositoryInterface;
use SunFinanceGroup\Notificator\Verification\Events\VerificationCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/** @codeCoverageIgnore */
final class VerificationEventListener implements EventSubscriberInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private NotificationRepositoryInterface $notificationRepository,
        private RendererInterface $renderer
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            VerificationCreated::class => [
                ['notify']
            ]
        ];
    }

    public function notify(VerificationCreated $event): void
    {
        $channel = 'EMAIL';
        if (strpos($event->getSubject()->getIdentity(), '+') === 0) {
            $channel = 'SMS';
        }

        $notification = new Notification(
            $event->getSubject()->getIdentity(),
            $channel,
            $this->renderer->render(
                $event->getSubject()->getType(),
                ['code' => $event->getCode()]
            )
        );

        $this->notificationRepository->save($notification);

        $this->messageBus->dispatch(new NotificationCommand($notification->getId()));
    }
}