<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum Resource: string
{
    case Account = '/accounts';
    case AccountByUuid = '/accounts/{uuid}';

    case DaemonDb = '/db';
    case DaemonDbChecksum = '/db/checksum';

    case DaemonToken = '/tokens';
    case DaemonTokenByUuid = '/tokens/{uuid}';

    case Device = '/devices';
    case DeviceByUuid = '/devices/{uuid}';

    case EmpireDate = '/empire-dates';
    case EmpireDateNext = '/empire-dates-next';
    case EmpireDateByUuid = '/empire-dates/{uuid}';

    case HealthCheck = '/health-check';

    case Habit = '/habits';
    case HabitByUuid = '/habits/{uuid}';

    case Legion = '/legions';
    case LegionByUuid = '/legions/{uuid}';

    case Log = '/logs';
}
