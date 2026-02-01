<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;

final readonly class LegionDeleteService implements LegionDeleteServiceInterface
{
    public function __construct(
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Legion
    {
        $entity = $this->legionRepository->getByUuid($uuid);
        $this->legionRepository->delete($entity);

        return $entity;
    }
}
