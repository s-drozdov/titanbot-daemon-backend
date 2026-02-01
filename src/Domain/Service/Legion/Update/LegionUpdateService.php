<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Legion\Update;

use Override;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;

final readonly class LegionUpdateService implements LegionUpdateServiceInterface
{
    public function __construct(
        private LegionRepositoryInterface $legionRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        UuidInterface $uuid,
        ?string $title,
        ?string $extTitle,
        ?int $payDayOfMonth,
    ): Legion {
        $entity = $this->legionRepository->getByUuid($uuid);

        if ($title !== null) {
            $entity->setTitle($title);
        }

        if ($extTitle !== null) {
            $entity->setExtTitle($extTitle);
        }

        if ($payDayOfMonth !== null) {
            $entity->setPayDayOfMonth($payDayOfMonth);
        }

        $this->legionRepository->update($entity);

        return $entity;
    }
}
