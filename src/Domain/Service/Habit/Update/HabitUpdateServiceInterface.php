<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

interface HabitUpdateServiceInterface extends ServiceInterface
{
    /**
     * @param ListInterface<Pixel>|null $pixelList
     * 
     * @throws InvalidArgumentException
     */
    public function perform(
        UuidInterface $uuid,
        ?string $action,
        ?ListInterface $pixelList,
        ?int $accountLogicalId,
        ?int $priority,
        ?string $triggerOcr,
        ?string $triggerShell,
        ?bool $isActive,
    ): Habit;
}
