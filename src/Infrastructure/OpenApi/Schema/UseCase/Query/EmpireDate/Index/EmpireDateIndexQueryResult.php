<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\EmpireDateDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\EmpireDateDto as EmpireDateDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class EmpireDateIndexQueryResult
{
    /**
     * @var MapInterface<string,EmpireDateDto> $uuid_to_empire_date_map
     */
    #[OA\Property(
        type: PhpType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: EmpireDateDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_empire_date_map;
}
