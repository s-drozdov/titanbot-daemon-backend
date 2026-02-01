<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Legion,LegionDto>
 */
readonly class LegionMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): LegionDto
    {
        return new LegionDto(
            uuid: $object->getUuid(),
            title: $object->getTitle(),
            ext_title: $object->getExtTitle(),
            pay_day_of_month: $object->getPayDayOfMonth(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Legion
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Legion::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return LegionDto::class;
    }
}
