<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Habit;

use DateTimeImmutable;
use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class HabitFactory implements HabitFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(
        string $action,
        ?ListInterface $pixelList = null,
        ?int $accountLogicalId = null,
        ?int $priority = null,
        ?string $triggerOcr = null,
        ?string $triggerShell = null,
        bool $isActive = true,
    ): Habit {
        $entity = new Habit(
            uuid: $this->uuidHelper->create(),
            accountLogicalId: $accountLogicalId,
            priority: $priority,
            triggerOcr: $triggerOcr,
            triggerShell: $triggerShell,
            action: $action,
            isActive: $isActive,
            updatedAt: new DateTimeImmutable(),
        );

        if ($pixelList !== null) {
            $entity->setPixelList(new ArrayCollection($pixelList->toArray()));
        }

        return $entity;
    }
}
