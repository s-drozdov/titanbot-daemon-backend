<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Enum;

enum ActivityType: string
{
    case Rowgplay = 'rowgplay';
    case Ajagplay = 'ajagplay';
}
