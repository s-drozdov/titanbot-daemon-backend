<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Update;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceUpdateCommand
{
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public ?bool $is_active;

    #[OA\Property(type: OpenApiType::string->value, nullable: true)]
    public ?ActivityType $activity_type;

    public ?bool $is_full_server_detection;

    public ?bool $is_able_to_clear_cache;
    
    public ?int $go_time_limit_seconds;
}
