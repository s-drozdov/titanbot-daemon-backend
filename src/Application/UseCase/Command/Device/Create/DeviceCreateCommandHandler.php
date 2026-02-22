<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Create;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Domain\Dto\Device\Create\DeviceCreateParamsDto;
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
        $paramsDto = new DeviceCreateParamsDto(
            physicalId: $command->physical_id,
            activityType: $command->activity_type,
            isActive: $command->is_active,
            isSsh: $command->is_ssh,
            isNeedToUpdate: $command->is_need_to_update,
            isFullServerDetection: $command->is_full_server_detection,
            isAbleToClearCache: $command->is_able_to_clear_cache,
            goTimeLimitSeconds: $command->go_time_limit_seconds,
        );

        $entity = $this->deviceCreateService->perform($paramsDto);
        
        $this->eventBus->dispatch(...$entity->pullEvents());

        return new DeviceCreateCommandResult(uuid: $entity->getUuid());
    }
}
