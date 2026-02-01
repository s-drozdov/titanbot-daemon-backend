<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PixelFilter;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @extends RepositoryInterface<Pixel>
 */
interface PixelRepositoryInterface extends RepositoryInterface
{
    public function save(Pixel $entity): void;

    /**
     * @return Pixel
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param PixelFilter $filter
     * 
     * @return PaginationResult<Pixel>
     */
    public function findByFilter(PixelFilter $filter): PaginationResult;

    public function delete(EntityInterface $entity): void;

    /**
     * @param ListInterface<Pixel> $entityList
     * 
     * @throws InvalidArgumentException
     */
    public function bulkDelete(ListInterface $entityList): void;
}
