<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum Role: string
{
    case Admin = 'ROLE_ADMIN';
    case Daemon = 'ROLE_DAEMON';
}
