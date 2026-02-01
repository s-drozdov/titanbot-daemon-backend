<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Index;

use Titanbot\Daemon\Application\Dto\DaemonTokenDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;
use Titanbot\Daemon\Library\Collection\MapInterface;

final readonly class DaemonTokenIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,DaemonTokenDto> $uuid_to_token_map */
        public MapInterface $uuid_to_token_map,
    ) {
        /*_*/
    }
}
