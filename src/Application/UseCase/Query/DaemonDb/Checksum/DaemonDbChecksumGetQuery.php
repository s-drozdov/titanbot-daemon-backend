<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class DaemonDbChecksumGetQuery implements QueryInterface
{
    public function __construct(
        public ?int $logical_id,
    ) {
        /*_*/
    }
}
