<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Device\Update;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class DeviceUpdateParamsDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?bool $isActive = null,
        public ?bool $isSsh = null,
        public ?bool $isNeedToUpdate = null,
        public ?ActivityType $activityType = null,
        public ?bool $isFullServerDetection = null,
        public ?bool $isAbleToClearCache = null,
        public ?int $goTimeLimitSeconds = null,
        public ?int $currentLogicalId = null,
    ) {
        /*_*/
    }
}
