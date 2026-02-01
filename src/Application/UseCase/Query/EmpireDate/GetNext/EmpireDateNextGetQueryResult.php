<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\GetNext;

use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class EmpireDateNextGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public ?int $unix_timestamp,
    ) {
        /*_*/
    }
}
