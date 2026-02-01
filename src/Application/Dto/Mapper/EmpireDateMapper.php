<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\EmpireDateDto;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<EmpireDate,EmpireDateDto>
 */
readonly class EmpireDateMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): EmpireDateDto
    {
        return new EmpireDateDto(
            uuid: $object->getUuid(),
            date: $object->getDate(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): EmpireDate
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return EmpireDate::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return EmpireDateDto::class;
    }
}
