<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Ssh\Create;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class SshCreateCommandResult implements CommandResultInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
