<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Create;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceCreateCommand
{
    public int $physical_id;

    public ?bool $is_active;

    public ?bool $is_ssh;

    #[OA\Property(type: OpenApiType::string->value, nullable: true)]
    public ?ActivityType $activity_type;

    public ?bool $is_full_server_detection;

    public ?bool $is_able_to_clear_cache;
    
    public ?int $go_time_limit_seconds;
}
