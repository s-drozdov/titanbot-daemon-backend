<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Event\Habit\PixelListReleased;
use Titanbot\Daemon\Domain\Event\Habit\ShapeListReleased;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Update\HabitUpdateParamsDto;

final readonly class HabitUpdateService implements HabitUpdateServiceInterface
{
    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(HabitUpdateParamsDto $paramsDto): Habit {
        $entity = $this->habitRepository->getByUuid($paramsDto->uuid);

        if ($paramsDto->action !== null) {
            $entity->setAction($paramsDto->action);
        }

        if ($paramsDto->pixelList !== null) {
            $this->modifyHabitWithPixelList($entity, $paramsDto->pixelList);
        }

        if ($paramsDto->accountLogicalId !== null) {
            $entity->setAccountLogicalId($paramsDto->accountLogicalId);
        }

        if ($paramsDto->priority !== null) {
            $entity->setPriority($paramsDto->priority);
        }

        if ($paramsDto->shapeList !== null) {
            $this->modifyHabitWithShapeList($entity, $paramsDto->shapeList);
        }

        if ($paramsDto->triggerShell !== null) {
            $entity->setTriggerShell($paramsDto->triggerShell);
        }

        if ($paramsDto->logTemplate !== null) {
            $entity->setLogTemplate($paramsDto->logTemplate);
        }

        if ($paramsDto->postTimeoutMs !== null) {
            $entity->setPostTimeoutMs($paramsDto->postTimeoutMs);
        }

        if ($paramsDto->comment !== null) {
            $entity->setComment($paramsDto->comment);
        }

        if ($paramsDto->sequence !== null) {
            $entity->setSequence($paramsDto->sequence);
        }

        if ($paramsDto->context !== null) {
            $entity->setContext($paramsDto->context);
        }

        if ($paramsDto->isInterruption !== null) {
            $entity->setIsInterruption($paramsDto->isInterruption);
        }

        if ($paramsDto->isActive !== null) {
            $entity->setIsActive($paramsDto->isActive);
        }

        $this->habitRepository->update($entity);

        return $entity;
    }

    /**
     * @param ListInterface<Pixel> $pixelList
     */
    private function modifyHabitWithPixelList(Habit $habit, ListInterface $pixelList): void
    {
        $currentPixelUuidList = array_map(
            fn (Pixel $pixel) => $pixel->getUuid(),
            $habit->getPixelList()->toArray(),
        );

        $newPixelUuidList = array_map(
            fn (Pixel $pixel) => $pixel->getUuid(),
            $pixelList->toArray(),
        );

        $possibleOrphanUuidList = array_diff($currentPixelUuidList, $newPixelUuidList);
        
        $habit->raise(
            new PixelListReleased(
                pixelUuidList: new Collection(
                    value: $possibleOrphanUuidList,
                    innerType: UuidInterface::class,
                ),
            ),
        );

        $habit->setPixelList(new ArrayCollection($pixelList->toArray()));
    }

    /**
     * @param ListInterface<Shape> $shapeList
     */
    private function modifyHabitWithShapeList(Habit $habit, ListInterface $shapeList): void
    {
        $currentShapeUuidList = array_map(
            fn (Shape $shape) => $shape->getUuid(),
            $habit->getShapeList()->toArray(),
        );

        $newShapeUuidList = array_map(
            fn (Shape $shape) => $shape->getUuid(),
            $shapeList->toArray(),
        );

        $possibleOrphanUuidList = array_diff($currentShapeUuidList, $newShapeUuidList);

        $habit->raise(
            new ShapeListReleased(
                shapeUuidList: new Collection(
                    value: $possibleOrphanUuidList,
                    innerType: UuidInterface::class,
                ),
            ),
        );

        $habit->setShapeList(new ArrayCollection($shapeList->toArray()));
    }
}
