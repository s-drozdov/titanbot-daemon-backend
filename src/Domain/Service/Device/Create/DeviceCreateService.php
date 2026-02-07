<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;
use Titanbot\Daemon\Domain\Factory\Device\DeviceFactoryInterface;
use Titanbot\Daemon\Domain\Dto\Device\Create\DeviceCreateParamsDto;

final readonly class DeviceCreateService implements DeviceCreateServiceInterface
{
    public function __construct(
        private DeviceFactoryInterface $deviceFactory,
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(DeviceCreateParamsDto $paramsDto): Device {
        $entity = $this->deviceFactory->create($paramsDto);
        
        $this->deviceRepository->save($entity);

        return $entity;
    }
}
