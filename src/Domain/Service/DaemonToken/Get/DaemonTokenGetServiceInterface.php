<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Get;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Entity\DaemonToken;

interface DaemonTokenGetServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(UuidInterface $uuid): DaemonToken;
}
