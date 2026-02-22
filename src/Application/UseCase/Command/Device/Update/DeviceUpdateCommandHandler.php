<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\Update;

use Override;
use Titanbot\Daemon\Application\Dto\Mapper\DeviceMapper;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Event\EventBusInterface;
use Titanbot\Daemon\Domain\Dto\Device\Update\DeviceUpdateParamsDto;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Update\DeviceUpdateServiceInterface;

/**
 * @implements CommandHandlerInterface<DeviceUpdateCommand,DeviceUpdateCommandResult>
 */
final readonly class DeviceUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DeviceUpdateServiceInterface $deviceUpdateService,

        /** @var DeviceMapper $deviceMapper */
        private DeviceMapper $deviceMapper,
        
        private EventBusInterface $eventBus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DeviceUpdateCommandResult
    {
        $paramsDto = new DeviceUpdateParamsDto(
            uuid: $command->uuid,
            isActive: $command->is_active,
            isSsh: $command->is_ssh,
            isNeedToUpdate: $command->is_need_to_update,
            activityType: $command->activity_type,
            isFullServerDetection: $command->is_full_server_detection,
            isAbleToClearCache: $command->is_able_to_clear_cache,
            goTimeLimitSeconds: $command->go_time_limit_seconds,
            currentLogicalId: $command->current_logical_id,
        );

        $entity = $this->deviceUpdateService->perform($paramsDto);

        $this->eventBus->dispatch(...$entity->pullEvents());

        return new DeviceUpdateCommandResult(
            device: $this->deviceMapper->mapDomainObjectToDto($entity),
        );
    }
}
