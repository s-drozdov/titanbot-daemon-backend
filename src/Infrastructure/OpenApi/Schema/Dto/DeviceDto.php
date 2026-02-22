<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceDto
{
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public int $physical_id;

    public bool $is_active;

    public bool $is_ssh;

    public bool $is_need_to_update;

    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public ActivityType $activity_type;

    public bool $is_full_server_detection;

    public bool $is_able_to_clear_cache;

    public int $go_time_limit_seconds;
    
    public ?int $current_logical_id;
}
