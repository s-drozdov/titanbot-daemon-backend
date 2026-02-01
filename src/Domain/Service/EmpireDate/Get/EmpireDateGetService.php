<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Get;

use Override;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;

final readonly class EmpireDateGetService implements EmpireDateGetServiceInterface
{
    public function __construct(
        private EmpireDateRepositoryInterface $empireDateRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): EmpireDate
    {
        return $this->empireDateRepository->getByUuid($uuid);
    }
}
