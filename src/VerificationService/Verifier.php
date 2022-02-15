<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\VerificationService;

use Psr\EventDispatcher\EventDispatcherInterface;
use SunFinanceGroup\Notificator\Verification\Subject;
use SunFinanceGroup\Notificator\Verification\UserInfo;
use SunFinanceGroup\Notificator\Verification\Verification;
use SunFinanceGroup\Notificator\VerificationService\Exception\DuplicateNonConfirmedVerifications;

final class Verifier implements VerifierInterface
{
    private const MAX_CONFIRMATION_ATTEMPTS = 5;

    public function __construct(
        private VerificationRepositoryInterface $repository,
        private VerificationCodeGeneratorInterface $codeGenerator,
        private EventDispatcherInterface $eventDispatcher,
        private int $ttlMinutes
    )
    {
    }

    public function createForSubject(Subject $subject, UserInfo $userInfo): Verification
    {
        $verification = $this->repository->findNonConfirmedForSubject($subject);

        if ($verification !== null) {
            throw new DuplicateNonConfirmedVerifications('Duplicated verification');
        }

        $expiredAt = (new \DateTime())->modify(sprintf('+%dminutes', $this->ttlMinutes));

        $verification = new Verification(
            $subject,
            $expiredAt,
            $this->codeGenerator->generate(),
            $userInfo,
            self::MAX_CONFIRMATION_ATTEMPTS
        );

        $this->repository->save($verification);

        foreach ($verification->flushEvents() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        return $verification;
    }

    public function confirm(string $uuid, string $code, UserInfo $userInfo): void
    {
        $verification = $this->repository->get($uuid);

        try {
            $verification->incrementAttempts();
            $verification->confirmByCodeAndUserInfo($code, $userInfo);
        } finally {
            $this->repository->save($verification);

            foreach ($verification->flushEvents() as $event) {
                $this->eventDispatcher->dispatch($event);
            }
        }
    }
}