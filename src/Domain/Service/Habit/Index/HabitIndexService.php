<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\HabitFilter;

final readonly class HabitIndexService implements HabitIndexServiceInterface
{
    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        ?int $accountLogicalId = null,
        ?bool $isActive = null,
        ?string $action = null,    
    ): PaginationResult {
        return $this->habitRepository->findByFilter(
            new HabitFilter(
                accountLogicalId: $accountLogicalId,
                isActive: $isActive,
                action: $action,
            ),
        );
    }
}
