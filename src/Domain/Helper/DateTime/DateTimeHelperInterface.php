<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Helper\DateTime;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\Helper\HelperInterface;

interface DateTimeHelperInterface extends HelperInterface
{
    public const string EMPIRE_LIMIT_MODIFIER = 'next monday';

    public function getNextEmpireLimitUnixTs(?DateTimeImmutable $nextDate): ?int;
}
