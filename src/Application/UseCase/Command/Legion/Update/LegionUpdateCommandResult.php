<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Update;

use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class LegionUpdateCommandResult implements CommandResultInterface
{
    public function __construct(
        public LegionDto $legion,
    ) {
        /*_*/
    }
}
