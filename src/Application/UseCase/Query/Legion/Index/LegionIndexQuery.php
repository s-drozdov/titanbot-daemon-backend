<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Legion\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class LegionIndexQuery implements QueryInterface
{
    public function __construct(
        public ?string $title,
        public ?int $pay_day_of_month,
    ) {
        /*_*/
    }
}
