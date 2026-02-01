<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Index;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface LegionIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Legion>
     */
    public function perform(?string $title = null, ?int $payDayOfMonth = null): PaginationResult;
}
