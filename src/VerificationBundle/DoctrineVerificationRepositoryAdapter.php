<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\MultipleVerificationExists;
use SunFinanceGroup\Notificator\VerificationService\Exception\VerificationNotFoundException;
use SunFinanceGroup\Notificator\VerificationService\VerificationRepositoryInterface;

final class DoctrineVerificationRepositoryAdapter implements VerificationRepositoryInterface
{
    private EntityManagerInterface $em;
    private ObjectRepository $doctrineRepo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->doctrineRepo = $this->em->getRepository(Verification::class);
    }

    public function findNonConfirmedForSubject(Subject $subject): ?Verification
    {
        /** @var Verification[] $verifications */
        $verifications = $this->doctrineRepo
            ->createQueryBuilder('v')
            ->where('v.subject.identity = :identity')
            ->andWhere('v.subject.type = :type')
            ->andWhere('v.confirmed = false')
            ->andWhere('v.expiredAt >= :now')
            ->setParameters([
                'identity' => $subject->getIdentity(),
                'type' => $subject->getType(),
                'now' => new \DateTimeImmutable(),
            ])
            ->getQuery()
            ->getResult();

        if (count($verifications) > 1) {
            throw new MultipleVerificationExists();
        }

        $verification = current($verifications);
        if ($verification === false) {
            return null;
        }

        return $verification;
    }

    public function get(string $uuid): Verification
    {
        /** @var Verification|null $verification */
        $verification = $this->doctrineRepo->find($uuid);

        if ($verification === null) {
            throw new VerificationNotFoundException();
        }

        return $verification;
    }

    public function save(Verification $verification): void
    {
        $this->em->persist($verification);
        $this->em->flush();
    }
}