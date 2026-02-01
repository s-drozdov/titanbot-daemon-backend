<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Create;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Enum\PhpType;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonTokenCreateCommandResult
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;
}
