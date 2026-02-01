<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

final readonly class DeviceDeleteService implements DeviceDeleteServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Device
    {
        $entity = $this->deviceRepository->getByUuid($uuid);
        $this->deviceRepository->delete($entity);

        return $entity;
    }
}
