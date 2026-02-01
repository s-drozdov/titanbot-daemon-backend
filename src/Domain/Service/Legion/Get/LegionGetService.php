<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Get;

use Override;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;

final readonly class LegionGetService implements LegionGetServiceInterface
{
    public function __construct(
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Legion
    {
        return $this->legionRepository->getByUuid($uuid);
    }
}
