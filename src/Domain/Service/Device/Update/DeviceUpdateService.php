<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Device\Update\DeviceUpdateParamsDto;

final readonly class DeviceUpdateService implements DeviceUpdateServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(DeviceUpdateParamsDto $paramsDto): Device {
        $entity = $this->deviceRepository->getByUuid($paramsDto->uuid);

        if ($paramsDto->isActive !== null) {
            $entity->setIsActive($paramsDto->isActive);
        }

        if ($paramsDto->activityType !== null) {
            $entity->setActivityType($paramsDto->activityType);
        }

        if ($paramsDto->isEmpireSleeping !== null) {
            $entity->setIsEmpireSleeping($paramsDto->isEmpireSleeping);
        }

        if ($paramsDto->isFullServerDetection !== null) {
            $entity->setIsFullServerDetection($paramsDto->isFullServerDetection);
        }

        if ($paramsDto->isAbleToClearCache !== null) {
            $entity->setIsAbleToClearCache($paramsDto->isAbleToClearCache);
        }

        if ($paramsDto->goTimeLimitSeconds !== null) {
            $entity->setGoTimeLimitSeconds($paramsDto->goTimeLimitSeconds);
        }

        $this->deviceRepository->update($entity);

        return $entity;
    }
}
