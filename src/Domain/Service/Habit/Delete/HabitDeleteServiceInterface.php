<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Delete;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface HabitDeleteServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Habit;
}
