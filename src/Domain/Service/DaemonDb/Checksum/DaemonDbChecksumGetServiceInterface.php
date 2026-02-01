<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonDb\Checksum;

use Titanbot\Daemon\Domain\Service\ServiceInterface;

interface DaemonDbChecksumGetServiceInterface extends ServiceInterface
{
    public function perform(?int $accountLogicalId): string;
}
