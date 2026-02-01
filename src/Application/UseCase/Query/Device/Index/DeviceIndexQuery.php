<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class DeviceIndexQuery implements QueryInterface
{
    public function __construct(
        public ?int $physical_id,
    ) {
        /*_*/
    }
}
