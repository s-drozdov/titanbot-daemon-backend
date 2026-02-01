<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\DaemonToken;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Entity\DaemonToken;

interface DaemonTokenFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(string $token): DaemonToken;
}
