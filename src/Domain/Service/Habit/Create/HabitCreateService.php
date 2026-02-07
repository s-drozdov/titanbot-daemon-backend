<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Habit\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Factory\Habit\HabitFactoryInterface;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;
use Titanbot\Daemon\Domain\Dto\Habit\Create\HabitCreateParamsDto;

final readonly class HabitCreateService implements HabitCreateServiceInterface
{
    public function __construct(
        private HabitFactoryInterface $habitFactory,
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(HabitCreateParamsDto $paramsDto): Habit {
        $entity = $this->habitFactory->create($paramsDto);
        
        $this->habitRepository->save($entity);

        return $entity;
    }
}
