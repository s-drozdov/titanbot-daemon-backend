<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum;

use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class DaemonDbChecksumGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public string $checksum,
    ) {
        /*_*/
    }
}
