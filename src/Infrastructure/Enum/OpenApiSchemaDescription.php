<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum OpenApiSchemaDescription: string
{
    case account = 'account';
    case daemon_db = 'daemon_db';
    case daemon_token = 'daemon_token';
    case device = 'device';
    case empire_date = 'empire_date';
    case habit = 'habit';
    case legion = 'legion';
    case log = 'log';
    case status = 'status';
}
