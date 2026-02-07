<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Habit;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Create\HabitCreateParamsDto;

interface HabitFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(HabitCreateParamsDto $paramsDto): Habit;
}
