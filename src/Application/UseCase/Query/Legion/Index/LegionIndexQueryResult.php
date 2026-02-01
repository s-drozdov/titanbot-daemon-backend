<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Legion\Index;

use Titanbot\Daemon\Application\Dto\LegionDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class LegionIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,LegionDto> $uuid_to_legion_map */
        public MapInterface $uuid_to_legion_map,
    ) {
        /*_*/
    }
}
