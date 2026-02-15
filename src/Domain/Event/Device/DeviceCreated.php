<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Event\Device;

use Titanbot\Daemon\Domain\Event\EventInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class DeviceCreated implements EventInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
