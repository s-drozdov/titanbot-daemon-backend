<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Create;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class AccountCreateCommandResult
{
    #[OA\Property(type: OpenApiType::string->value, nullable: false)]
    public UuidInterface $uuid;
}
