<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum Action: string
{
    case AccountPost = 'account_create';
    case AccountGet = 'account_read';
    case AccountIndex = 'account_index';
    case AccountUpdate = 'account_update';
    case AccountDelete = 'account_delete';

    case DaemonTokenPost = 'daemon_token_create';
    case DaemonTokenGet = 'daemon_token_read';
    case DaemonTokenByValueGet = 'daemon_token_by_value_read';
    case DaemonTokenIndex = 'daemon_token_index';
    case DaemonTokenDelete = 'daemon_token_delete';
    case DaemonTokenDeleteByValue = 'daemon_token_delete_by_value';

    case DaemonDbGet = 'daemon_db_read';
    case DaemonDbChecksumGet = 'daemon_db_checksum_read';

    case DevicePost = 'device_create';
    case DeviceGet = 'device_read';
    case DeviceIndex = 'device_index';
    case DeviceUpdate = 'device_update';
    case DeviceDelete = 'device_delete';

    case EmpireDatePost = 'empire_date_create';
    case EmpireDateGet = 'empire_date_read';
    case EmpireDateNextGet = 'empire_date_next_read';
    case EmpireDateIndex = 'empire_date_index';
    case EmpireDateDelete = 'empire_date_delete';

    case HabitPost = 'habit_create';
    case HabitGet = 'habit_read';
    case HabitIndex = 'habit_index';
    case HabitUpdate = 'habit_update';
    case HabitDelete = 'habit_delete';

    case HealthCheck = 'health_check';
    
    case LegionPost = 'legion_create';
    case LegionGet = 'legion_read';
    case LegionIndex = 'legion_index';
    case LegionUpdate = 'legion_update';
    case LegionDelete = 'legion_delete';

    case LogPost = 'log_create';
    case LogIndex = 'log_index';
    case LogClear = 'log_clear';
}
