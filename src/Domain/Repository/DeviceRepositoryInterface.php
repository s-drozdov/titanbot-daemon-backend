<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\DeviceFilter;

/**
 * @extends RepositoryInterface<Device>
 */
interface DeviceRepositoryInterface extends RepositoryInterface
{
    public function save(Device $entity): void;

    /**
     * @return Device
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface;

    /**
     * @param DeviceFilter $filter
     * 
     * @return PaginationResult<Device>
     */
    public function findByFilter(DeviceFilter $filter): PaginationResult;

    public function update(Device $entity): void;

    public function delete(EntityInterface $entity): void;
}
