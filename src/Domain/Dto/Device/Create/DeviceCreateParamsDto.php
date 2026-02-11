<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Device\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Enum\ActivityType;

final readonly class DeviceCreateParamsDto implements DtoInterface
{
    public function __construct(
        public int $physicalId,
        public ?ActivityType $activityType = null,
        public ?bool $isActive = null,
        public ?bool $isFullServerDetection = null,
        public ?bool $isAbleToClearCache = null,
        public ?int $goTimeLimitSeconds = null,
    ) {
        /*_*/
    }
}
