<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Device;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Device\Create\DeviceCreateParamsDto;

interface DeviceFactoryInterface extends FactoryInterface
{
    public const bool DEFAULT_IS_ACTIVE = false;
    public const bool DEFAULT_IS_SSH = false;
    public const bool DEFAULT_IS_NEED_TO_UPDATE = false;
    public const ActivityType DEFAULT_ACTIVITY_TYPE = ActivityType::Rowgplay;
    public const bool DEFAULT_IS_FULL_SERVER_DETECTION = false;
    public const bool DEFAULT_IS_ABLE_TO_CLEAR_CACHE = false;
    public const int DEFAULT_GO_TIME_LIMIT_SECONDS = 100;

    /**
     * @throws InvalidArgumentException
     */
    public function create(DeviceCreateParamsDto $paramsDto): Device;
}
