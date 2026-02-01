<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;

final readonly class AccountDeleteService implements AccountDeleteServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Account
    {
        $entity = $this->accountRepository->getByUuid($uuid);
        $this->accountRepository->delete($entity);

        return $entity;
    }
}
