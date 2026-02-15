<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Ssh\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Domain\Factory\Ssh\SshFactoryInterface;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;
use Titanbot\Daemon\Domain\Repository\SshRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

final readonly class SshCreateService implements SshCreateServiceInterface
{
    public function __construct(
        private SshFactoryInterface $sshFactory,
        private DeviceRepositoryInterface $deviceRepository,
        private SshRepositoryInterface $sshRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(SshCreateParamsDto $paramsDto): Ssh {
        $device = $this->deviceRepository->getByUuid($paramsDto->deviceUuid);
        $ssh = $this->sshFactory->create($paramsDto);

        $device->setSsh($ssh);

        $this->sshRepository->save($ssh);
        $this->deviceRepository->update($device);

        return $ssh;
    }
}
