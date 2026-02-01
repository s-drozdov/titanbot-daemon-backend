<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Legion;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class LegionFactory implements LegionFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(
        string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion {
        return new Legion(
            uuid: $this->uuidHelper->create(),
            title: $title,
            extTitle: $extTitle,
            payDayOfMonth: $payDayOfMonth,
        );
    }
}
