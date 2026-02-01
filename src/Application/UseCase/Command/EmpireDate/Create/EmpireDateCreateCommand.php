<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create;

use DateTimeImmutable;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class EmpireDateCreateCommand implements CommandInterface
{
    public function __construct(
        public DateTimeImmutable $date,
    ) {
        /*_*/
    }
}
