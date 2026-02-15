<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Ssh\GetByDevice;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;
use Webmozart\Assert\Assert;

final readonly class SshByDeviceGetService implements SshByDeviceGetServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $deviceUuid): Ssh
    {
        $device = $this->deviceRepository->getByUuid($deviceUuid);
        $ssh = $device->getSsh();
        
        Assert::notNull($ssh);

        return $ssh;
    }
}
