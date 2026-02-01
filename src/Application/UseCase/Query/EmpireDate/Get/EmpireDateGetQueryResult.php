<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Get;

use Titanbot\Daemon\Application\Dto\EmpireDateDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class EmpireDateGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public EmpireDateDto $empire_date,
    ) {
        /*_*/
    }
}
