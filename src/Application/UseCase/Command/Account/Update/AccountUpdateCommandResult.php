<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Account\Update;

use Titanbot\Daemon\Application\Dto\AccountDto;
use Titanbot\Daemon\Application\Bus\Command\CommandResultInterface;

final readonly class AccountUpdateCommandResult implements CommandResultInterface
{
    public function __construct(
        public AccountDto $account,
    ) {
        /*_*/
    }
}
