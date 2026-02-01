<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Legion\Get;

use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class LegionGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public LegionDto $legion,
    ) {
        /*_*/
    }
}
