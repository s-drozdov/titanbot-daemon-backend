<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice;

use Titanbot\Daemon\Application\Dto\SshDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class SshByDeviceGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public SshDto $ssh,
    ) {
        /*_*/
    }
}
