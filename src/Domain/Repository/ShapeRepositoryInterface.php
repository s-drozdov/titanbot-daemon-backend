<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Repository\Filter\ShapeFilter;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @extends RepositoryInterface<Shape>
 */
interface ShapeRepositoryInterface extends RepositoryInterface
{
    public function save(Shape $entity): void;

    /**
     * @return Shape
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param ShapeFilter $filter
     *
     * @return PaginationResult<Shape>
     */
    public function findByFilter(ShapeFilter $filter): PaginationResult;

    public function delete(EntityInterface $entity): void;

    /**
     * @param ListInterface<Shape> $entityList
     *
     * @throws InvalidArgumentException
     */
    public function bulkDelete(ListInterface $entityList): void;
}
