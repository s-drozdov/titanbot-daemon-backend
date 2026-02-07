<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Device\Create\DeviceCreateParamsDto;

interface DeviceCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(DeviceCreateParamsDto $paramsDto): Device;
}
