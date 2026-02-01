<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Get;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;

final readonly class HabitGetService implements HabitGetServiceInterface
{
    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): Habit
    {
        return $this->habitRepository->getByUuid($uuid);
    }
}
