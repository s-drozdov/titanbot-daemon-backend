<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Event\Habit\PixelListReleased;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;

final readonly class HabitDeleteService implements HabitDeleteServiceInterface
{
    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Habit
    {
        $habit = $this->habitRepository->getByUuid($uuid);

        $pixelUuidList = new Collection(
            value: array_map(
                fn (Pixel $pixel) => $pixel->getUuid(),
                $habit->getPixelList()->toArray(),
            ),
            innerType: UuidInterface::class,
        );

        $this->habitRepository->delete($habit);

        
        $habit->raise(
            new PixelListReleased(pixelUuidList: $pixelUuidList),
        );

        return $habit;
    }
}
