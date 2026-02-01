<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Get;

use Override;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;

final readonly class AccountGetService implements AccountGetServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Account
    {
        return $this->accountRepository->getByUuid($uuid);
    }
}
