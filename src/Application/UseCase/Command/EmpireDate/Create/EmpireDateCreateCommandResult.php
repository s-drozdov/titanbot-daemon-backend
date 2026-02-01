<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class EmpireDateCreateCommandResult implements CommandResultInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
