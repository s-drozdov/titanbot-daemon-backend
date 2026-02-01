<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Log\Create;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class LogCreateCommand implements CommandInterface
{
    public function __construct(
        public string $message,
    ) {
        /*_*/
    }
}