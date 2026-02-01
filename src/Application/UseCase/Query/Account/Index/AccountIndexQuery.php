<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class AccountIndexQuery implements QueryInterface
{
    public function __construct(
        public ?int $logical_id,
    ) {
        /*_*/
    }
}
