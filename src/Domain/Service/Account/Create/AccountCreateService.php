<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Create;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;
use Titanbot\Daemon\Domain\Factory\Account\AccountFactoryInterface;

final readonly class AccountCreateService implements AccountCreateServiceInterface
{
    public function __construct(
        private AccountFactoryInterface $accountFactory,
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        int $logicalId,
        string $firstName,
        string $lastName,
        DateTimeImmutable $birthDate,
        Gender $gender,
        string $googleLogin,
        string $googlePassword,
    ): Account {
        $entity = $this->accountFactory->create(
            logicalId: $logicalId,
            firstName: $firstName,
            lastName: $lastName,
            birthDate: $birthDate,
            gender: $gender,
            googleLogin: $googleLogin,
            googlePassword: $googlePassword,
        );
        
        $this->accountRepository->save($entity);

        return $entity;
    }
}
