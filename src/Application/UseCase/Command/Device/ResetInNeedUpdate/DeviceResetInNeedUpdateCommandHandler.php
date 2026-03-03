<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Device\ResetInNeedUpdate;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\ResetInNeedUpdate\DeviceResetInNeedUpdateServiceInterface;

/**
 * @implements CommandHandlerInterface<DeviceResetInNeedUpdateCommand,DeviceResetInNeedUpdateCommandResult>
 */
final readonly class DeviceResetInNeedUpdateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DeviceResetInNeedUpdateServiceInterface $deviceResetInNeedUpdateService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): DeviceResetInNeedUpdateCommandResult
    {
        $this->deviceResetInNeedUpdateService->perform($command->uuid);

        return new DeviceResetInNeedUpdateCommandResult();
    }
}
