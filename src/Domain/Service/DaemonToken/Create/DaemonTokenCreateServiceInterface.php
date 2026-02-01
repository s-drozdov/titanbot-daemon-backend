<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface DaemonTokenCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(string $token): DaemonToken;
}
