<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Legion\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\LegionDto as LegionDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LegionIndexQueryResult
{
    /**
     * @var MapInterface<string,LegionDto> $uuid_to_legion_map
     */
    #[OA\Property(
        type: PhpType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: LegionDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_legion_map;
}
