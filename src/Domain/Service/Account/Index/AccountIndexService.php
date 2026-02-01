<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\AccountFilter;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;

final readonly class AccountIndexService implements AccountIndexServiceInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?int $logicalId = null): PaginationResult
    {
        return $this->accountRepository->findByFilter(
            new AccountFilter(logicalId: $logicalId),
        );
    }
}
