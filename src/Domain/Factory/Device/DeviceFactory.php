<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Device;

use Override;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class DeviceFactory implements DeviceFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(
        int $physicalId,
        ?bool $isActive = null,
        ?ActivityType $activityType = null,
        ?bool $isEmpireSleeping = null,
        ?bool $isFullServerDetection = null,
        ?bool $isAbleToClearCache = null,
        ?int $goTimeLimitSeconds = null,
    ): Device {

        return new Device(
            uuid: $this->uuidHelper->create(),
            physicalId: $physicalId,
            isActive: $isActive ?? self::DEFAULT_IS_ACTIVE,
            activityType: $activityType ?? self::DEFAULT_ACTIVITY_TYPE,
            isEmpireSleeping: $isEmpireSleeping ?? self::DEFAULT_IS_EMPIRE_SLEEPING,
            isFullServerDetection: $isFullServerDetection ?? self::DEFAULT_IS_FULL_SERVER_DETECTION,
            isAbleToClearCache: $isAbleToClearCache ?? self::DEFAULT_IS_ABLE_TO_CLEAR_CACHE,
            goTimeLimitSeconds: $goTimeLimitSeconds ?? self::DEFAULT_GO_TIME_LIMIT_SECONDS,
        );
    }
}
