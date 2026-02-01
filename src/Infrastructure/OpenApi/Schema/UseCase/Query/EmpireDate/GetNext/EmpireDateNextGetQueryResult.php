<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\GetNext;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class EmpireDateNextGetQueryResult
{
    public ?int $unix_timestamp;
}
