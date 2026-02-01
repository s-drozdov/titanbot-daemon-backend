<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index;

use Titanbot\Daemon\Application\Dto\EmpireDateDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class EmpireDateIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,EmpireDateDto> $uuid_to_empire_date_map */
        public MapInterface $uuid_to_empire_date_map,
    ) {
        /*_*/
    }
}
