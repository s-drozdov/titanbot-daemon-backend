<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Account;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Account\Create\AccountCreateParamsDto;

interface AccountFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(AccountCreateParamsDto $paramsDto): Account;
}
