<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Habit\Delete\HabitDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<HabitDeleteCommand,HabitDeleteCommandResult>
 */
final readonly class HabitDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private HabitDeleteServiceInterface $habitDeleteService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): HabitDeleteCommandResult
    {
        $entity = $this->habitDeleteService->perform($command->uuid);
        $this->eventBus->dispatch(...$entity->pullEvents());

        return new HabitDeleteCommandResult();
    }
}
