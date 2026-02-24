<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Ssh\Create;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class SshCreateCommand implements CommandInterface
{
    public function __construct(
        public int $physical_id,
        public ?int $server_device_internal_port = null,
    ) {
        /*_*/
    }
}
