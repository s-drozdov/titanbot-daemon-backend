<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Index;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface DaemonTokenIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<DaemonToken>
     */
    public function perform(?string $token = null): PaginationResult;
}
