<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Update\HabitUpdateParamsDto;

interface HabitUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(HabitUpdateParamsDto $paramsDto): Habit;
}
