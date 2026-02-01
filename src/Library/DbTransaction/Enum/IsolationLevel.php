<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Library\DbTransaction\Enum;

enum IsolationLevel: string
{
    case READ_UNCOMMITTED = 'read_uncommited';
    case READ_COMMITTED = 'read_committed';
    case REPEATABLE_READ = 'repeatable_read';
    case SERIALIZABLE = 'serializable';
}
