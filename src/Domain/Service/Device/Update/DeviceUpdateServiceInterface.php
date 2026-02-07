<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Update;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Device\Update\DeviceUpdateParamsDto;

interface DeviceUpdateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(DeviceUpdateParamsDto $paramsDto): Device;
}
