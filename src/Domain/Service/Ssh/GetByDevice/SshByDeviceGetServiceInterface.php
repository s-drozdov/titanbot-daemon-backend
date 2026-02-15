<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Ssh\GetByDevice;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;

interface SshByDeviceGetServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $deviceUuid): Ssh;
}
