<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Habit\Update;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

final readonly class HabitUpdateParamsDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?string $action,

        /** @var ListInterface<Pixel>|null $pixelList */
        public ?ListInterface $pixelList,
        
        public ?int $accountLogicalId,
        public ?int $priority,
        public ?string $triggerOcr,
        public ?string $triggerShell,
        public ?string $logTemplate,
        public ?int $postTimeoutMs,
        public ?string $comment,
        public ?int $sequence,
        public ?string $context,
        public ?bool $isActive,
    ) {
        /*_*/
    }
}
