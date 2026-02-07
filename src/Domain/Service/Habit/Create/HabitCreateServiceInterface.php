<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Create\HabitCreateParamsDto;

interface HabitCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(HabitCreateParamsDto $paramsDto): Habit;
}
