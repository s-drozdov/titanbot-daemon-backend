<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\DaemonToken\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\DaemonTokenDto;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\DaemonTokenDto as DaemonTokenDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DaemonTokenIndexQueryResult
{
    /**
     * @var MapInterface<string,DaemonTokenDto> $uuid_to_token_map
     */
    #[OA\Property(
        type: OpenApiType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: DaemonTokenDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_token_map;
}
