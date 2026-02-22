<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Create;

use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class DeviceCreateCommand implements CommandInterface
{
    public function __construct(
        public int $physical_id,
        public ?bool $is_active,
        public ?bool $is_ssh,
        public ?bool $is_need_to_update,
        public ?ActivityType $activity_type,
        public ?bool $is_full_server_detection,
        public ?bool $is_able_to_clear_cache,
        public ?int $go_time_limit_seconds,
    ) {
        /*_*/
    }
}
