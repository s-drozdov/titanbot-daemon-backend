<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Get;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class HabitGetQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
