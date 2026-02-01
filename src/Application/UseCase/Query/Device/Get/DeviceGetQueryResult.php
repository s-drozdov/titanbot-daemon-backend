<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Get;

use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class DeviceGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public DeviceDto $device,
    ) {
        /*_*/
    }
}
