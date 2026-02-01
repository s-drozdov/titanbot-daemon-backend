<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Application\Dto\DaemonTokenDto;
use Titanbot\Daemon\Domain\Entity\DaemonToken;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<DaemonToken,DaemonTokenDto>
 */
readonly class DaemonTokenMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): DaemonTokenDto
    {
        return new DaemonTokenDto(
            uuid: $object->getUuid(),
            token: $object->getToken(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): DaemonToken
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return DaemonToken::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return DaemonTokenDto::class;
    }
}
