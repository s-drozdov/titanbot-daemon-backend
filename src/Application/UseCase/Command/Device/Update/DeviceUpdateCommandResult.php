<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Update;

use Titanbot\Daemon\Application\Dto\DeviceDto;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class DeviceUpdateCommandResult implements CommandResultInterface
{
    public function __construct(
        public DeviceDto $device,
    ) {
        /*_*/
    }
}
