<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\PixelDto;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Pixel,PixelDto>
 */
readonly class PixelMapper implements MapperInterface
{
    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): PixelDto
    {
        return new PixelDto(
            uuid: $object->getUuid(),
            x: $object->getDot()->getX(),
            y: $object->getDot()->getY(),
            rgb_hex: $object->getColor()->getRgbHex(),
            deviation: $object->getColor()->getDeviation(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Pixel
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Pixel::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return PixelDto::class;
    }
}
