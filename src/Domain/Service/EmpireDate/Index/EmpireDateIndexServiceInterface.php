<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Index;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface EmpireDateIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<EmpireDate>
     */
    public function perform(?DateTimeImmutable $date = null): PaginationResult;
}
