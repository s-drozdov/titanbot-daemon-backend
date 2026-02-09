<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Enum;

enum OpenApiType: string
{
    case string = 'string';
    case number = 'number';
    case integer = 'integer';
    case boolean = 'boolean';
    case array = 'array';
    case object = 'object';
}
