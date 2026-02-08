<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum OpenApiTag: string
{
    case Account = 'account';
    case DaemonDb = 'daemon_db';
    case DaemonToken = 'daemon_token';
    case Device = 'device';
    case EmpireDate = 'empire_date';
    case Habit = 'habit';
    case Legion = 'legion';
    case Log = 'log';
    case Status = 'status';

    case AdminAccess = 'admin_access';
    case DaemonAccess = 'daemon_access';
}
