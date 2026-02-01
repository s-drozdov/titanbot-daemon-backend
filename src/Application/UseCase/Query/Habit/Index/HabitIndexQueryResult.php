<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Index;

use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class HabitIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,HabitDto> $uuid_to_habit_map */
        public MapInterface $uuid_to_habit_map,
    ) {
        /*_*/
    }
}
