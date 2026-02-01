<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface DeviceCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        int $physicalId,
        ?ActivityType $activityType = null,
        ?bool $isActive = null,
        ?bool $isEmpireSleeping = null,
        ?bool $isFullServerDetection = null,
        ?bool $isAbleToClearCache = null,
        ?int $goTimeLimitSeconds = null,
    ): Device;
}
