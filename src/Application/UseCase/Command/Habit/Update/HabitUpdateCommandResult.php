<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Update;

use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class HabitUpdateCommandResult implements CommandResultInterface
{
    public function __construct(
        public HabitDto $habit,
    ) {
        /*_*/
    }
}
