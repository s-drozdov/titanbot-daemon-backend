<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\DaemonTokenFilter;

/**
 * @extends RepositoryInterface<DaemonToken>
 */
interface DaemonTokenRepositoryInterface extends RepositoryInterface
{
    public function save(DaemonToken $entity): void;

    /**
     * @return DaemonToken
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param DaemonTokenFilter $filter
     * 
     * @return PaginationResult<DaemonToken>
     */
    public function findByFilter(DaemonTokenFilter $filter): PaginationResult;

    public function delete(EntityInterface $entity): void;
}
