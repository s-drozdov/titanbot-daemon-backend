<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Account\Create\AccountCreateParamsDto;

interface AccountCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(AccountCreateParamsDto $paramsDto): Account;
}
