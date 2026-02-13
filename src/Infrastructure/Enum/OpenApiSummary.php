<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum OpenApiSummary: string
{
    case AccountCreate = 'Create account';
    case AccountGet = 'Get account';
    case AccountIndex = 'Get account index';
    case AccountUpdate = 'Update account';
    case AccountDelete = 'Delete account';

    case DaemonDbGet = 'Get daemon db';
    case DaemonDbChecksumGet = 'Get daemon db checksum';

    case DaemonTokenCreate = 'Create daemon token';
    case DaemonTokenGet = 'Get daemon token';
    case DaemonTokenByValueGet = 'Get daemon token by token value';
    case DaemonTokenIndex = 'Get daemon token index';
    case DaemonTokenDelete = 'Delete daemon token';
    case DaemonTokenDeleteByValue = 'Delete daemon token by token value';

    case DeviceCreate = 'Create device';
    case DeviceGet = 'Get device';
    case DeviceIndex = 'Get device index';
    case DeviceUpdate = 'Update device';
    case DeviceDelete = 'Delete device';

    case EmpireDateCreate = 'Create empire date';
    case EmpireDateGet = 'Get empire date';
    case EmpireDateNextGet = 'Get next empire date';
    case EmpireDateIndex = 'Get empire date index';
    case EmpireDateDelete = 'Delete empire date';

    case HabitCreate = 'Create habit';
    case HabitGet = 'Get habit';
    case HabitIndex = 'Get habit index';
    case HabitUpdate = 'Update habit';
    case HabitDelete = 'Delete habit';

    case HealthCheck = 'Health check';

    case LegionCreate = 'Create legion';
    case LegionGet = 'Get legion';
    case LegionIndex = 'Get legion index';
    case LegionUpdate = 'Update legion';
    case LegionDelete = 'Delete legion';

    case LogCreate = 'Create log';
    case LogIndex = 'Get log index';
    case LogClear = 'Clear all daemon logs';
    case LogBulkCreate = 'Create multiple logs';
}
