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
            port: $object->getPort(),
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
