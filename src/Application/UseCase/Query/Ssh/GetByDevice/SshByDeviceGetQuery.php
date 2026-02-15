<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class SshByDeviceGetQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $device_uuid,
    ) {
        /*_*/
    }
}
