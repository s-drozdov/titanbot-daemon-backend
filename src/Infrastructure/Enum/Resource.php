<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum Resource: string
{
    case Account = '/daemon/accounts';
    case AccountByUuid = '/daemon/accounts/{uuid}';

    case BackendPublicKey = '/daemon/backend/public-key';

    case DaemonDb = '/daemon/db';
    case DaemonDbChecksum = '/daemon/db/checksum';

    case DaemonToken = '/daemon/tokens';
    case DaemonTokenByUuid = '/daemon/tokens/{uuid}';

    case Device = '/daemon/devices';
    case DeviceByUuid = '/daemon/devices/{uuid}';
    case DeviceSsh = '/daemon/devices/{uuid}/ssh';

    case EmpireDate = '/daemon/empire-dates';
    case EmpireDateNext = '/daemon/empire-dates-next';
    case EmpireDateByUuid = '/daemon/empire-dates/{uuid}';

    case HealthCheck = '/daemon/health-check';

    case Habit = '/daemon/habits';
    case HabitByUuid = '/daemon/habits/{uuid}';

    case Legion = '/daemon/legions';
    case LegionByUuid = '/daemon/legions/{uuid}';

    case Log = '/daemon/logs';
    case LogBulk = '/daemon/logs/bulk';
}
