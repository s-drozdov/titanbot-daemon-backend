<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Log\CreateBulk;

use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class LogBulkCreateCommand implements CommandInterface
{
    public function __construct(

        /** @var ListInterface<LogDto> $log_dto_list */
        public ListInterface $log_dto_list,
    ) {
        /*_*/
    }
}