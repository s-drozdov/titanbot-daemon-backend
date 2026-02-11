<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Update;

use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class DeviceUpdateCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?bool $is_active,
        public ?ActivityType $activity_type,
        public ?bool $is_full_server_detection,
        public ?bool $is_able_to_clear_cache,
        public ?int $go_time_limit_seconds,
        public ?int $current_logical_id,
    ) {
        /*_*/
    }
}
