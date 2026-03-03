<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\ResetInNeedUpdate;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class DeviceResetInNeedUpdateCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
