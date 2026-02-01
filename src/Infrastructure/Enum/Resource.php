<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum Resource: string
{
    case Account = '/accounts';
    case AccountByUuid = '/accounts/{uuid}';

    case DaemonDb = '/daemon-db';
    case DaemonDbChecksum = '/daemon-db/checksum';

    case DaemonToken = '/daemon/tokens';
    case DaemonTokenByUuid = '/daemon/tokens/{uuid}';

    case Device = '/devices';
    case DeviceByUuid = '/devices/{uuid}';

    case EmpireDate = '/empire-dates';
    case EmpireDateNext = '/empire-dates-next';
    case EmpireDateByUuid = '/empire-dates/{uuid}';

    case HealthCheck = '/health-check';

    case Habit = '/habit';
    case HabitByUuid = '/habit/{uuid}';

    case Legion = '/legions';
    case LegionByUuid = '/legions/{uuid}';

    case Log = '/logs';
}
