<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\Habit\Dot;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\Filter\DotFilter;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @extends RepositoryInterface<Dot>
 */
interface DotRepositoryInterface extends RepositoryInterface
{
    public function save(Dot $entity): void;

    /**
     * @return Dot
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param DotFilter $filter
     * 
     * @return PaginationResult<Dot>
     */
    public function findByFilter(DotFilter $filter): PaginationResult;

    public function delete(EntityInterface $entity): void;
}
