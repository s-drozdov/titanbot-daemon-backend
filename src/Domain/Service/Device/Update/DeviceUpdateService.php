<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Update;

use Override;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

final readonly class DeviceUpdateService implements DeviceUpdateServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        UuidInterface $uuid,
        ?bool $isActive = null,
        ?ActivityType $activityType = null,
        ?bool $isEmpireSleeping = null,
        ?bool $isFullServerDetection = null,
        ?bool $isAbleToClearCache = null,
        ?int $goTimeLimitSeconds = null,
    ): Device {
        $entity = $this->deviceRepository->getByUuid($uuid);

        if ($isActive !== null) {
            $entity->setIsActive($isActive);
        }

        if ($activityType !== null) {
            $entity->setActivityType($activityType);
        }

        if ($isEmpireSleeping !== null) {
            $entity->setIsEmpireSleeping($isEmpireSleeping);
        }

        if ($isFullServerDetection !== null) {
            $entity->setIsFullServerDetection($isFullServerDetection);
        }

        if ($isAbleToClearCache !== null) {
            $entity->setIsAbleToClearCache($isAbleToClearCache);
        }

        if ($goTimeLimitSeconds !== null) {
            $entity->setGoTimeLimitSeconds($goTimeLimitSeconds);
        }

        $this->deviceRepository->update($entity);

        return $entity;
    }
}
