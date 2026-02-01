<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Device\Get;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;

interface DeviceGetServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): Device;
}
