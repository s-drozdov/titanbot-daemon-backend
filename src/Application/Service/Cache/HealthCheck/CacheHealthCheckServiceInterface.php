<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Cache\HealthCheck;

interface CacheHealthCheckServiceInterface
{
    public function perform(): void;
}
