<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Ssh\Generate;

use RuntimeException;
use Titanbot\Daemon\Application\Dto\SshPairDto;

interface SshPairGenerateServiceInterface
{
    /**
     * @throws RuntimeException
     */
    public function perform(int $physicalId): SshPairDto;
}
