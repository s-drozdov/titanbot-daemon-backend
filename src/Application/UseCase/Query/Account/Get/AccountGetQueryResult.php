<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Get;

use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class AccountGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public AccountDto $account,
    ) {
        /*_*/
    }
}
