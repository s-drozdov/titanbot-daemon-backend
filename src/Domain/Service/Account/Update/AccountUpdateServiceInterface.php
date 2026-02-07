<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Account\Update\AccountUpdateParamsDto;

interface AccountUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(AccountUpdateParamsDto $paramsDto): Account;
}
