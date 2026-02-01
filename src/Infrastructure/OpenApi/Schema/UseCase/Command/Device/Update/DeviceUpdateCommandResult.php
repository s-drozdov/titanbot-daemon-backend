<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Update;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\DeviceDto as DeviceDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class DeviceUpdateCommandResult
{
    #[OA\Property(
        ref: new Model(type: DeviceDtoSchema::class)
    )]
    public DeviceDto $device;
}
