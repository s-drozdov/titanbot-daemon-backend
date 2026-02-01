<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Helper\DateTime;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Helper\DateTime\DateTimeHelperInterface;

final readonly class DateTimeHelper implements DateTimeHelperInterface
{
    #[Override]
    public function getNextEmpireLimitUnixTs(?DateTimeImmutable $nextDate): ?int
    {
        if ($nextDate === null) {
            return null;
        }

        $weekday = (int) $nextDate->format('N');

        if ($weekday === 1 && (int)$nextDate->format('H') < 3) {
            return $nextDate->setTime(3, 0, 0)->getTimestamp();
        }

        return $nextDate->modify(self::EMPIRE_LIMIT_MODIFIER)->setTime(3, 0, 0)->getTimestamp();
    }
}
