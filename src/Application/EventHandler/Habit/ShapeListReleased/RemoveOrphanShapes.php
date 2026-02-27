<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\EventHandler\Habit\ShapeListReleased;

use Titanbot\Daemon\Domain\Event\Habit\ShapeListReleased;
use Titanbot\Daemon\Application\Bus\Event\EventHandlerInterface;
use Titanbot\Daemon\Domain\Service\Shape\Delete\ShapeDeleteServiceInterface;
use Titanbot\Daemon\Domain\Service\Shape\Get\ShapeGetServiceInterface;

/**
 * @implements EventHandlerInterface<ShapeListReleased>
 */
final readonly class RemoveOrphanShapes implements EventHandlerInterface
{
    public function __construct(
        private ShapeGetServiceInterface $shapeGetService,
        private ShapeDeleteServiceInterface $shapeDeleteService,
    ) {
        /*_*/
    }

    public function __invoke(ShapeListReleased $event): void
    {
        foreach ($event->shapeUuidList as $uuid) {
            $shape = $this->shapeGetService->perform($uuid);

            if (count($shape->getHabitList()) === 0) {
                $this->shapeDeleteService->perform($uuid);
            }
        }
    }
}
