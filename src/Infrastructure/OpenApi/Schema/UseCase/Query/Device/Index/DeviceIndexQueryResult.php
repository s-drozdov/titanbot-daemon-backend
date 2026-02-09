<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Device\Index;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\DeviceDto as DeviceDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceIndexQueryResult
{
    /**
     * @var MapInterface<string,DeviceDto> $uuid_to_device_map
     */
    #[OA\Property(
        type: OpenApiType::object->value,
        additionalProperties: new OA\AdditionalProperties(
            ref: new Model(type: DeviceDtoSchema::class),
        ),
    )]
    public MapInterface $uuid_to_device_map;
}
