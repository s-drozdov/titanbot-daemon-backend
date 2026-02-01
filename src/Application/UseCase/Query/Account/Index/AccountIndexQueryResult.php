<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Index;

use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Library\Collection\MapInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class AccountIndexQueryResult implements QueryResultInterface
{
    public function __construct(

        /** @var MapInterface<string,AccountDto> $uuid_to_account_map */
        public MapInterface $uuid_to_account_map,
    ) {
        /*_*/
    }
}
