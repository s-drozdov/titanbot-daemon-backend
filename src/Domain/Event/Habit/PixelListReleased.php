<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Event\Habit;

use Titanbot\Daemon\Domain\Event\EventInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

final readonly class PixelListReleased implements EventInterface
{
    public function __construct(

        /** @var ListInterface<UuidInterface> $pixelUuidList */
        public ListInterface $pixelUuidList,
    ) {
        /*_*/
    }
}
