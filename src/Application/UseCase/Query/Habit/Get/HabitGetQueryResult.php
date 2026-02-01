<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Get;

use Titanbot\Daemon\Application\Dto\HabitDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class HabitGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public HabitDto $habit,
    ) {
        /*_*/
    }
}
