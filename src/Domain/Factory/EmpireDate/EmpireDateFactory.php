<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\EmpireDate;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class EmpireDateFactory implements EmpireDateFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(
        DateTimeImmutable $date,
    ): EmpireDate {
        return new EmpireDate(
            uuid: $this->uuidHelper->create(),
            date: $date,
        );
    }
}
