<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\LegionFilter;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;

final readonly class LegionIndexService implements LegionIndexServiceInterface
{
    public function __construct(
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?string $title = null, ?int $payDayOfMonth = null): PaginationResult
    {
        return $this->legionRepository->findByFilter(
            new LegionFilter(
                title: $title,
                payDayOfMonth: $payDayOfMonth,
            ),
        );
    }
}
