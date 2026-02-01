<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;

interface DeviceUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(
        UuidInterface $uuid,
        ?bool $isActive = null,
        ?ActivityType $activityType = null,
        ?bool $isEmpireSleeping = null,
        ?bool $isFullServerDetection = null,
        ?bool $isAbleToClearCache = null,
        ?int $goTimeLimitSeconds = null,
    ): Device;
}
