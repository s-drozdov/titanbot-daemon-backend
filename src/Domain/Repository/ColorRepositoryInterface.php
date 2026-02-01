<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\Habit\Color;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\Filter\ColorFilter;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @extends RepositoryInterface<Color>
 */
interface ColorRepositoryInterface extends RepositoryInterface
{
    public function save(Color $entity): void;

    /**
     * @return Color
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param ColorFilter $filter
     * 
     * @return PaginationResult<Color>
     */
    public function findByFilter(ColorFilter $filter): PaginationResult;

    public function delete(EntityInterface $entity): void;
}
