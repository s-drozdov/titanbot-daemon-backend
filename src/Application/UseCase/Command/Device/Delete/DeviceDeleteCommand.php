<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Delete;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class DeviceDeleteCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
