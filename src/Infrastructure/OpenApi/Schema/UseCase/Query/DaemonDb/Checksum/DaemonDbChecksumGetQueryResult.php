<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\DaemonDb\Checksum;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonDbChecksumGetQueryResult
{
    public string $checksum;
}
