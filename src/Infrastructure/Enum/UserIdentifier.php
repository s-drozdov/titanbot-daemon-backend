<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum UserIdentifier: string
{
    case Admin = 'admin';
    case Daemon = 'daemon';
}
