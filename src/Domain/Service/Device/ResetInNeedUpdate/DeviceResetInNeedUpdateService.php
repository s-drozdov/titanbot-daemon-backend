<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\ResetInNeedUpdate;

use Override;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

final readonly class DeviceResetInNeedUpdateService implements DeviceResetInNeedUpdateServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): void
    {
        $entity = $this->deviceRepository->getByUuid($uuid);
        $entity->setIsNeedToUpdate(false);

        $this->deviceRepository->update($entity);
    }
}
