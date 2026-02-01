<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\Factory\Device\DeviceFactoryInterface;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

final readonly class DeviceCreateService implements DeviceCreateServiceInterface
{
    public function __construct(
        private DeviceFactoryInterface $deviceFactory,
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        int $physicalId,
        ?ActivityType $activityType = null,
        ?bool $isActive = null,
        ?bool $isEmpireSleeping = null,
        ?bool $isFullServerDetection = null,
        ?bool $isAbleToClearCache = null,
        ?int $goTimeLimitSeconds = null,
    ): Device {
        $entity = $this->deviceFactory->create(
            physicalId: $physicalId,
            isActive: $isActive,
            activityType: $activityType,
            isEmpireSleeping: $isEmpireSleeping,
            isFullServerDetection: $isFullServerDetection,
            isAbleToClearCache: $isAbleToClearCache,
            goTimeLimitSeconds: $goTimeLimitSeconds,
        );
        
        $this->deviceRepository->save($entity);

        return $entity;
    }
}
