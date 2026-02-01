<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Legion\Get;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\LegionDto as LegionDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LegionGetQueryResult
{
    #[OA\Property(
        ref: new Model(type: LegionDtoSchema::class)
    )]
    public LegionDto $legion;
}
