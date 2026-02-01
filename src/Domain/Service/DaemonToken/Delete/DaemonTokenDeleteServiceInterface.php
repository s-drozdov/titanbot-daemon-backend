<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Delete;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface DaemonTokenDeleteServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): DaemonToken;
}
