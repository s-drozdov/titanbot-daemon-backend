<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use Override;
use LogicException;
use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Application\Dto\PixelDto;
use Titanbot\Daemon\Application\Dto\ShapeDto;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 * 
 * @implements MapperInterface<Habit,HabitDto>
 */
readonly class HabitMapper implements MapperInterface
{
    public function __construct(
        private PixelMapper $pixelMapper,
        private ShapeMapper $shapeMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function mapDomainObjectToDto(DomainObjectInterface $object): HabitDto
    {
        /** @var array<array-key,Pixel> $pixelList */
        $pixelList = $object->getPixelList()->toArray();

        /** @var array<array-key,Shape> $shapeList */
        $shapeList = $object->getShapeList()->toArray();

        return new HabitDto(
            uuid: $object->getUuid(),
            action: $object->getAction(),
            pixelList: new Collection(
                value: array_map(
                    fn (Pixel $pixel): PixelDto => $this->pixelMapper->mapDomainObjectToDto($pixel),
                    $pixelList,
                ),
                innerType: PixelDto::class,
            ),
            shapeList: new Collection(
                value: array_map(
                    fn (Shape $shape): ShapeDto => $this->shapeMapper->mapDomainObjectToDto($shape),
                    $shapeList,
                ),
                innerType: ShapeDto::class,
            ),
            is_active: $object->isActive(),
            updated_at: $object->getUpdatedAt(),
            account_logical_id: $object->getAccountLogicalId(),
            priority: $object->getPriority(),
            trigger_shell: $object->getTriggerShell(),
            log_template: $object->getLogTemplate(),
            post_timeout_ms: $object->getPostTimeoutMs(),
            comment: $object->getComment(),
            sequence: $object->getSequence(),
            context: $object->getContext(),
            is_interruption: $object->isInterruption(),
        );
    }

    #[Override]
    public function mapDtoToDomainObject(DtoInterface $dto): Habit
    {
        throw new LogicException();
    }

    #[Override]
    public function getEntityType(): string
    {
        return Habit::class;
    }

    #[Override]
    public function getDtoType(): string
    {
        return HabitDto::class;
    }
}
