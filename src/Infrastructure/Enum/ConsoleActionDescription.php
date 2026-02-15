<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum ConsoleActionDescription: string
{
    case SshRotate = 'Rotate device ssh key';
    case DignosticsCacheDump = 'Cache dump key';
    case DignosticsCacheHealthCheck = 'Cache health check';
}
