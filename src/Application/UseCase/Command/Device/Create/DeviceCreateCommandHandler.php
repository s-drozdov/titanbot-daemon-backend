<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Create\DeviceCreateServiceInterface;

/**
 * @implements CommandHandlerInterface<DeviceCreateCommand,DeviceCreateCommandResult>
 */
final readonly class DeviceCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DeviceCreateServiceInterface $deviceCreateService,
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DeviceCreateCommandResult
    {
        $entity = $this->deviceCreateService->perform(
            physicalId: $command->physical_id,
            activityType: $command->activity_type,
            isActive: $command->is_active,
            isEmpireSleeping: $command->is_empire_sleeping,
            isFullServerDetection: $command->is_full_server_detection,
            isAbleToClearCache: $command->is_able_to_clear_cache,
            goTimeLimitSeconds: $command->go_time_limit_seconds
        );
        
        $this->eventBus->dispatch(...$entity->pullEvents());

        return new DeviceCreateCommandResult(uuid: $entity->getUuid());
    }
}
