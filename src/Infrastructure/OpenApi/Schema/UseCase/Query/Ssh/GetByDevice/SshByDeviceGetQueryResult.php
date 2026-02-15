<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Ssh\GetByDevice;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\SshDto as SshDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class SshByDeviceGetQueryResult
{
    #[OA\Property(
        ref: new Model(type: SshDtoSchema::class)
    )]
    public Ssh $ssh;
}
