<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum ConsoleAction: string
{
    case SshRotate = 'ssh:rotate';
    case DignosticsCacheDump = 'diagnostics:cache:dump';
    case DignosticsCacheHealthCheck = 'diagnostics:cache:health-check';
}
