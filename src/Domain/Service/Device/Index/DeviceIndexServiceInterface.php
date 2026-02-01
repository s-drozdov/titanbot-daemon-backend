<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Index;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

interface DeviceIndexServiceInterface extends ServiceInterface
{
    /**
     * @return PaginationResult<Device>
     */
    public function perform(?int $physicalId = null): PaginationResult;
}
