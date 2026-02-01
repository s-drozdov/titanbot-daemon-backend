<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\GetNext;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;

final readonly class EmpireDateNextGetService implements EmpireDateNextGetServiceInterface
{
    public function __construct(
        private EmpireDateRepositoryInterface $empireDateRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(): ?EmpireDate
    {
        $now = new DateTimeImmutable();
        
        return $this->empireDateRepository->findNext($now);
    }
}
