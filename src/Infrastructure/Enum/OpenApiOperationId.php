<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum OpenApiOperationId: string
{
    case AccountCreate = 'createAccount';
    case AccountGet = 'getAccount';
    case AccountIndex = 'getAccountIndex';
    case AccountUpdate = 'updateAccount';
    case AccountDelete = 'deleteAccount';

    case DaemonDbGet = 'getDaemonDb';
    case DaemonDbChecksumGet = 'getDaemonDbChecksum';

    case DaemonTokenCreate = 'createDaemonToken';
    case DaemonTokenGet = 'getDaemonToken';
    case DaemonTokenByValueGet = 'getDaemonTokenByValue';
    case DaemonTokenIndex = 'getDaemonTokenIndex';
    case DaemonTokenDelete = 'deleteDaemonToken';
    case DaemonTokenDeleteByValue = 'deleteDaemonTokenByValue';

    case DeviceCreate = 'createDevice';
    case DeviceGet = 'getDevice';
    case DeviceIndex = 'getDeviceIndex';
    case DeviceUpdate = 'updateDevice';
    case DeviceDelete = 'deleteDevice';

    case EmpireDateCreate = 'createEmpireDate';
    case EmpireDateGet = 'getEmpireDate';
    case EmpireDateNextGet = 'getNextEmpireDate';
    case EmpireDateIndex = 'getEmpireDateIndex';
    case EmpireDateDelete = 'deleteEmpireDate';

    case HabitCreate = 'createHabit';
    case HabitGet = 'getHabit';
    case HabitIndex = 'getHabitIndex';
    case HabitUpdate = 'updateHabit';
    case HabitDelete = 'deleteHabit';

    case HealthCheck = 'checkHealth';
    
    case LegionCreate = 'createLegion';
    case LegionGet = 'getLegion';
    case LegionIndex = 'getLegionIndex';
    case LegionUpdate = 'updateLegion';
    case LegionDelete = 'deleteLegion';
    
    case LogCreate = 'createLog';
    case LogIndex = 'getLogIndex';
    case LogClear = 'crearLog';
}
