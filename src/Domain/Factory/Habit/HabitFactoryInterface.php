<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Habit;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

interface HabitFactoryInterface extends FactoryInterface
{
    /**
     * @param ListInterface<Pixel>|null $pixelList
     * 
     * @throws InvalidArgumentException
     */
    public function create(
        string $action,
        ?ListInterface $pixelList = null,
        ?int $accountLogicalId = null,
        ?int $priority = null,
        ?string $triggerOcr = null,
        ?string $triggerShell = null,
        bool $isActive = true,
    ): Habit;
}
