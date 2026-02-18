<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Habit\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Library\Collection\ListInterface;

final readonly class HabitCreateParamsDto implements DtoInterface
{
    public function __construct(
        public string $action,

        /** @var ListInterface<Pixel>|null $pixelList */
        public ?ListInterface $pixelList = null,
        
        public ?int $accountLogicalId = null,
        public ?int $priority = null,
        public ?string $triggerOcr = null,
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
