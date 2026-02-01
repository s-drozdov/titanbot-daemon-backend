<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class HabitIndexQuery implements QueryInterface
{
    public function __construct(
        public ?int $account_logical_id = null,
        public ?bool $is_active = null,
        public ?string $action = null, 
    ) {
        /*_*/
    }
}
