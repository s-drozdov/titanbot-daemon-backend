<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Update;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Event\Habit\PixelListReleased;
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

        if ($paramsDto->triggerOcr !== null) {
            $entity->setTriggerOcr($paramsDto->triggerOcr);
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
}
