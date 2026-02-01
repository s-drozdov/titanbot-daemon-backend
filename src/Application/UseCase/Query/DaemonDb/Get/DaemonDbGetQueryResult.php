<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get;

use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class DaemonDbGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public string $temp_file,
    ) {
        /*_*/
    }
}
