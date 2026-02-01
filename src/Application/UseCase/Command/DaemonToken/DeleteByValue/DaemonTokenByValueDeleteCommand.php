<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\DaemonToken\DeleteByValue;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class DaemonTokenByValueDeleteCommand implements CommandInterface
{
    public function __construct(
        public string $token,
    ) {
        /*_*/
    }
}
