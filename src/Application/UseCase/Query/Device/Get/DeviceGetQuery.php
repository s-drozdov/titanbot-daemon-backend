<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Get;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class DeviceGetQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
