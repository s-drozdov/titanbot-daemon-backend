<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Delete;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface DeviceDeleteServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Device;
}
