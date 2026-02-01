<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Get;

use Titanbot\Daemon\Application\Dto\DaemonTokenDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class DaemonTokenGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public DaemonTokenDto $daemon_token,
    ) {
        /*_*/
    }
}
