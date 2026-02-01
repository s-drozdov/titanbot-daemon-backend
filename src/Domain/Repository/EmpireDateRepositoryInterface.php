<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\EmpireDateFilter;

/**
 * @extends RepositoryInterface<EmpireDate>
 */
interface EmpireDateRepositoryInterface extends RepositoryInterface
{
    public function save(EmpireDate $entity): void;

    /**
     * @return EmpireDate
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    public function findNext(DateTimeImmutable $now): ?EmpireDate;

    /**
     * @param EmpireDateFilter $filter
     * 
     * @return PaginationResult<EmpireDate>
     */
    public function findByFilter(EmpireDateFilter $filter): PaginationResult;

    public function update(EmpireDate $entity): void;

    public function delete(EntityInterface $entity): void;
}
