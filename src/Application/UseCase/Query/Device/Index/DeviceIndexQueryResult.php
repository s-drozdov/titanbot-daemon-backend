<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Index;

use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class DeviceIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,DeviceDto> $uuid_to_device_map */
        public MapInterface $uuid_to_device_map,
    ) {
        /*_*/
    }
}
