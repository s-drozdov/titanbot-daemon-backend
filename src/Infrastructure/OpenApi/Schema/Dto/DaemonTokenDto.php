<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonTokenDto
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public string $token;
}
