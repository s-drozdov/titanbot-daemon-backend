<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class DaemonDbGetQuery implements QueryInterface
{
    public function __construct(
        public ?int $logical_id,
    ) {
        /*_*/
    }
}
