<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\EventHandler\Device\Created;

use Titanbot\Daemon\Domain\Event\Device\DeviceCreated;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;
use Titanbot\Daemon\Application\Bus\Event\EventHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Get\DeviceGetServiceInterface;
use Titanbot\Daemon\Domain\Service\Ssh\Create\SshCreateServiceInterface;
use Titanbot\Daemon\Application\Service\Ssh\Generate\SshPairGenerateServiceInterface;

/**
 * @implements EventHandlerInterface<DeviceCreated>
 */
final readonly class GenerateSsh implements EventHandlerInterface
{
    public function __construct(
        private DeviceGetServiceInterface $deviceGetService,
        private SshPairGenerateServiceInterface $sshPairGenerateService,
        private SshCreateServiceInterface $sshCreateService,
    ) {
        /*_*/
    }

    public function __invoke(DeviceCreated $event): void
    {
        $device = $this->deviceGetService->perform($event->uuid);
        $sshPairDto = $this->sshPairGenerateService->perform($device->getPhysicalId());

        $paramsDto = new SshCreateParamsDto(
            deviceUuid: $event->uuid,
            public: $sshPairDto->public,
            private: $sshPairDto->private,
        );

        $this->sshCreateService->perform($paramsDto);
    }
}
