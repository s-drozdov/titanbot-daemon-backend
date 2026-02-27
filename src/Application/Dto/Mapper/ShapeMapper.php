<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\ShapeDto;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 *
 * @implements MapperInterface<Shape,ShapeDto>
 */
readonly class ShapeMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): ShapeDto
    {
        return new ShapeDto(
            uuid: $object->getUuid(),
            type: $object->getType()->value,
            x: $object->getX(),
            y: $object->getY(),
            width: $object->getWidth(),
            height: $object->getHeight(),
            rgb_hex: $object->getRgbHex(),
            size: $object->getSize(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Shape
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Shape::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return ShapeDto::class;
    }
}
