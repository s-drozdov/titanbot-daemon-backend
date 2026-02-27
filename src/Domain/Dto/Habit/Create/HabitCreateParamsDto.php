<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Habit\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Entity\Habit\Shape;
use Titanbot\Daemon\Library\Collection\ListInterface;

final readonly class HabitCreateParamsDto implements DtoInterface
{
    public function __construct(
        /** @var ListInterface<Pixel>|null $pixelList */
        public ?ListInterface $pixelList = null,

        /** @var ListInterface<Shape>|null $shapeList */
        public ?ListInterface $shapeList = null,

        public ?string $action = null,
        public ?int $accountLogicalId = null,
        public ?int $priority = null,
        public ?string $triggerShell = null,
        public ?string $logTemplate = null,
        public ?int $postTimeoutMs = null,
        public ?string $comment = null,
        public ?int $sequence = null,
        public ?string $context = null,
        public bool $isInterruption = true,
        public bool $isActive = true,
    ) {
        /*_*/
    }
}
