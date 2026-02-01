<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\LegionFilter;

/**
 * @extends RepositoryInterface<Legion>
 */
interface LegionRepositoryInterface extends RepositoryInterface
{
    public function save(Legion $entity): void;

    /**
     * @return Legion
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param LegionFilter $filter
     * 
     * @return PaginationResult<Legion>
     */
    public function findByFilter(LegionFilter $filter): PaginationResult;

    public function update(Legion $entity): void;

    public function delete(EntityInterface $entity): void;
}
