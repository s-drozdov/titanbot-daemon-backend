<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Create;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Enum\PhpType;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceCreateCommandResult
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;
}
