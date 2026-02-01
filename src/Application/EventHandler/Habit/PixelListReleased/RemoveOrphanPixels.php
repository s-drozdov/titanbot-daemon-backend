<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\EventHandler\Habit\PixelListReleased;

use Titanbot\Daemon\Domain\Event\Habit\PixelListReleased;
use Titanbot\Daemon\Application\Bus\Event\EventHandlerInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Delete\PixelDeleteServiceInterface;
use Titanbot\Daemon\Domain\Service\Pixel\Get\PixelGetServiceInterface;

/**
 * @implements EventHandlerInterface<PixelListReleased>
 */
final readonly class RemoveOrphanPixels implements EventHandlerInterface
{
    public function __construct(
        private PixelGetServiceInterface $pixelGetService,
        private PixelDeleteServiceInterface $pixelDeleteService,
    ) {
        /*_*/
    }

    public function __invoke(PixelListReleased $event): void
    {
        foreach ($event->pixelUuidList as $uuid) {
            $pixel = $this->pixelGetService->perform($uuid);

            if (count($pixel->getHabitList()) === 0) {
                $this->pixelDeleteService->perform($uuid);
            }
        }
    }
}
