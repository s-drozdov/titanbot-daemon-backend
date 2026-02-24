<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Webmozart\Assert\Assert;
use Titanbot\Daemon\Application\Dto\SshDto;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Ssh,SshDto>
 */
readonly class SshMapper implements MapperInterface
{
    public function __construct(
        private string $serverName,
        private string $serverIp,
        private int $serverCommonPort,
    ) {
        /*_*/
    }

    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): SshDto
    {
        $device = $object->getDevice();
        Assert::notNull($device);

        return new SshDto(
            uuid: $object->getUuid(),
            physical_id: $device->getPhysicalId(),
            public: $object->getPublic(),
            private: $object->getPrivate(),

            server_device_internal_port: $object->getServerDeviceInternalPort(),
            
            server_name: $this->serverName,
            server_ip: $this->serverIp,
            server_common_port: $this->serverCommonPort,
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Ssh
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Ssh::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return SshDto::class;
    }
}
