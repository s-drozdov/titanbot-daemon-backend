<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonDb\Get;

use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface DaemonDbGetServiceInterface extends ServiceInterface
{
    public function perform(?int $accountLogicalId): string;
}
