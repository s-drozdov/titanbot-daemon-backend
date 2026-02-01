<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Index;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Repository\Filter\EmpireDateFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;

final readonly class EmpireDateIndexService implements EmpireDateIndexServiceInterface
{
    public function __construct(
        private EmpireDateRepositoryInterface $empireDateRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?DateTimeImmutable $date = null): PaginationResult
    {
        return $this->empireDateRepository->findByFilter(
            new EmpireDateFilter(date: $date),
        );
    }
}
