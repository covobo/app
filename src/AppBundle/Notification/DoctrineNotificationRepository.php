<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use SunFinanceGroup\Notificator\Notification\Notification;
use SunFinanceGroup\Notificator\NotificationService\NotificationRepositoryInterface;

final class DoctrineNotificationRepository implements NotificationRepositoryInterface
{
    private EntityManagerInterface $em;
    private ObjectRepository $doctrineRepo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->doctrineRepo = $this->em->getRepository(Notification::class);
    }

    public function get(string $uuid): Notification
    {
        /** @var Notification|null $notification */
        $notification = $this->doctrineRepo->find($uuid);

        if ($notification === null) {
            throw new \RuntimeException();
        }

        return $notification;
    }

    public function save(Notification $notification): void
    {
        $this->em->persist($notification);
        $this->em->flush();
    }
}