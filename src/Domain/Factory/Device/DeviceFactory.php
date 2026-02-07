<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Device;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Dto\Device\Create\DeviceCreateParamsDto;

final readonly class DeviceFactory implements DeviceFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(DeviceCreateParamsDto $paramsDto): Device {

        return new Device(
            uuid: $this->uuidHelper->create(),
            physicalId: $paramsDto->physicalId,
            isActive: $paramsDto->isActive ?? self::DEFAULT_IS_ACTIVE,
            activityType: $paramsDto->activityType ?? self::DEFAULT_ACTIVITY_TYPE,
            isEmpireSleeping: $paramsDto->isEmpireSleeping ?? self::DEFAULT_IS_EMPIRE_SLEEPING,
            isFullServerDetection: $paramsDto->isFullServerDetection ?? self::DEFAULT_IS_FULL_SERVER_DETECTION,
            isAbleToClearCache: $paramsDto->isAbleToClearCache ?? self::DEFAULT_IS_ABLE_TO_CLEAR_CACHE,
            goTimeLimitSeconds: $paramsDto->goTimeLimitSeconds ?? self::DEFAULT_GO_TIME_LIMIT_SECONDS,
        );
    }
}
