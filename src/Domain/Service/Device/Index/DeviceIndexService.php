<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\DeviceFilter;

final readonly class DeviceIndexService implements DeviceIndexServiceInterface
{
    public function __construct(
        private DeviceRepositoryInterface $deviceRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?int $physicalId = null): PaginationResult
    {
        return $this->deviceRepository->findByFilter(
            new DeviceFilter(physicalId: $physicalId),
        );
    }
}
