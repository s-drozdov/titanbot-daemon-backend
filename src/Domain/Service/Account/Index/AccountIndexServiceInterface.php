<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Account\Index;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface AccountIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Account>
     */
    public function perform(?int $logicalId = null): PaginationResult;
}
