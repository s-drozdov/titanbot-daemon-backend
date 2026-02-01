<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Factory\Habit\HabitFactoryInterface;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;

final readonly class HabitCreateService implements HabitCreateServiceInterface
{
    public function __construct(
        private HabitFactoryInterface $habitFactory,
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(
        string $action,
        ?ListInterface $pixelList = null,
        ?int $accountLogicalId = null,
        ?int $priority = null,
        ?string $triggerOcr = null,
        ?string $triggerShell = null,
        bool $isActive = true,
    ): Habit {
        $entity = $this->habitFactory->create(
            action: $action,
            pixelList: $pixelList,
            accountLogicalId: $accountLogicalId,
            priority: $priority,
            triggerOcr: $triggerOcr,
            triggerShell: $triggerShell,
            isActive: $isActive,
        );
        
        $this->habitRepository->save($entity);

        return $entity;
    }
}
