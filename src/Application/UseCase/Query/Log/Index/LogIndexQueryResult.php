<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Log\Index;

use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class LogIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var ListInterface<LogDto> $log_list */
        public ListInterface $log_list,
    ) {
        /*_*/
    }
}
