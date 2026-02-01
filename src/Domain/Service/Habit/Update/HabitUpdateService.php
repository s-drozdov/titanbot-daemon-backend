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

final readonly class HabitUpdateService implements HabitUpdateServiceInterface
{
    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        UuidInterface $uuid,
        ?string $action,
        ?ListInterface $pixelList,
        ?int $accountLogicalId,
        ?int $priority,
        ?string $triggerOcr,
        ?string $triggerShell,
        ?bool $isActive,
    ): Habit {
        $entity = $this->habitRepository->getByUuid($uuid);

        if ($action !== null) {
            $entity->setAction($action);
        }

        if ($pixelList !== null) {
            $this->modifyHabitWithPixelList($entity, $pixelList);
        }

        if ($accountLogicalId !== null) {
            $entity->setAccountLogicalId($accountLogicalId);
        }

        if ($priority !== null) {
            $entity->setPriority($priority);
        }

        if ($triggerOcr !== null) {
            $entity->setTriggerOcr($triggerOcr);
        }

        if ($triggerShell !== null) {
            $entity->setTriggerShell($triggerShell);
        }

        if ($isActive !== null) {
            $entity->setIsActive($isActive);
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
