<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\AccountFilter;

/**
 * @extends RepositoryInterface<Account>
 */
interface AccountRepositoryInterface extends RepositoryInterface
{
    public function save(Account $entity): void;

    /**
     * @return Account
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param AccountFilter $filter
     * 
     * @return PaginationResult<Account>
     */
    public function findByFilter(AccountFilter $filter): PaginationResult;

    public function update(Account $entity): void;

    public function delete(EntityInterface $entity): void;
}
