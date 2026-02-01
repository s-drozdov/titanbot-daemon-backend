<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\Filter\HabitFilter;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @extends RepositoryInterface<Habit>
 */
interface HabitRepositoryInterface extends RepositoryInterface
{
    public function save(Habit $entity): void;

    /**
     * @return Habit
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    public function getVersion(?int $accountLogicalId): ?DateTimeImmutable;

    /**
     * @param HabitFilter $filter
     * 
     * @return PaginationResult<Habit>
     */
    public function findByFilter(HabitFilter $filter): PaginationResult;

    public function update(Habit $entity): void;

    public function delete(EntityInterface $entity): void;
}
