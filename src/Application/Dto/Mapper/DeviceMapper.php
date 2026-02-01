<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Device,DeviceDto>
 */
readonly class DeviceMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): DeviceDto
    {
        return new DeviceDto(
            uuid: $object->getUuid(),
            physical_id: $object->getPhysicalId(),
            is_active: $object->isActive(),
            activity_type: $object->getActivityType(),
            is_empire_sleeping: $object->isEmpireSleeping(),
            is_full_server_detection: $object->isFullServerDetection(),
            is_able_to_clear_cache: $object->isAbleToClearCache(),
            go_time_limit_seconds: $object->getGoTimeLimitSeconds(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Device
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Device::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return DeviceDto::class;
    }
}
