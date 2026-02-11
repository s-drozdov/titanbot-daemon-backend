<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class DeviceDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public int $physical_id,
        public bool $is_active,
        public ActivityType $activity_type,
        public bool $is_full_server_detection,
        public bool $is_able_to_clear_cache,
        public int $go_time_limit_seconds,
        public ?int $current_logical_id,
    ) {
        /*_*/
    }
}
