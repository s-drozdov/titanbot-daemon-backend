<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\DaemonToken\Get;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\DaemonTokenDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\DaemonTokenDto as DaemonTokenDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonTokenGetQueryResult
{
    #[OA\Property(
        ref: new Model(type: DaemonTokenDtoSchema::class)
    )]
    public DaemonTokenDto $daemon_token;
}
