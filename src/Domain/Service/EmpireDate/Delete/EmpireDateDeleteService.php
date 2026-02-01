<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;

final readonly class EmpireDateDeleteService implements EmpireDateDeleteServiceInterface
{
    public function __construct(
        private EmpireDateRepositoryInterface $empireDateRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): EmpireDate
    {
        $entity = $this->empireDateRepository->getByUuid($uuid);
        $this->empireDateRepository->delete($entity);

        return $entity;
    }
}
