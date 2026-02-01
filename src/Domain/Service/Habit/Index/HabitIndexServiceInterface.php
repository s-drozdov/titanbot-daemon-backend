<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Index;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface HabitIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Habit>
     */
    public function perform(
        ?int $accountLogicalId = null,
        ?bool $isActive = null,
        ?string $action = null,    
    ): PaginationResult;
}
