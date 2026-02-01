<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Create;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonTokenCreateCommand
{
    public string $token;
}
