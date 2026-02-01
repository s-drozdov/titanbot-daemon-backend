<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Create;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class DaemonTokenCreateCommand implements CommandInterface
{
    public function __construct(
        public string $token,
    ) {
        /*_*/
    }
}
