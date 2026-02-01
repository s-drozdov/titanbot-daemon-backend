<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\Create;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;
use Titanbot\Daemon\Domain\Factory\EmpireDate\EmpireDateFactoryInterface;

final readonly class EmpireDateCreateService implements EmpireDateCreateServiceInterface
{
    public function __construct(
        private EmpireDateFactoryInterface $empireDateFactory,
        private EmpireDateRepositoryInterface $empireDateRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        DateTimeImmutable $date,
    ): EmpireDate {
        $entity = $this->empireDateFactory->create(
            date: $date,
        );
        
        $this->empireDateRepository->save($entity);

        return $entity;
    }
}
