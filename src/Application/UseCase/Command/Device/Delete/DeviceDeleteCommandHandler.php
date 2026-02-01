<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Delete;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Delete\DeviceDeleteServiceInterface;

/**
 * @implements CommandHandlerInterface<DeviceDeleteCommand,DeviceDeleteCommandResult>
 */
final readonly class DeviceDeleteCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DeviceDeleteServiceInterface $deviceDeleteService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DeviceDeleteCommandResult
    {
        $entity = $this->deviceDeleteService->perform($command->uuid);
        $this->eventBus->dispatch(...$entity->pullEvents());

        return new DeviceDeleteCommandResult();
    }
}
