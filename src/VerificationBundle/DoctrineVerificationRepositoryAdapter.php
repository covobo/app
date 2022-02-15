<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationBundle;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\MultipleVerificationExists;
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
            ->findBy([
                'subject.identity' => $subject->getIdentity(),
                'subject.type' => $subject->getType()
            ]);

        if (count($verifications) > 1) {
            throw new MultipleVerificationExists();
        }

        $verification = current($verifications);
        if ($verification === false) {
            return null;
        }

        return $verification;
    }

    public function save(Verification $verification): void
    {
        $this->em->persist($verification);
        $this->em->flush();
    }
}