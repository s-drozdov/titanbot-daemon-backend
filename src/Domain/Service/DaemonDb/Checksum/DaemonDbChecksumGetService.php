<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonDb\Checksum;

use DateTimeImmutable;
use Override;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;

final readonly class DaemonDbChecksumGetService implements DaemonDbChecksumGetServiceInterface
{
    private const string EMPTY_DATABASE_VERSION_VALUE = 'empty-database';

    public function __construct(
        private HabitRepositoryInterface $habitRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?int $accountLogicalId): string
    {
        $updatedAt = $this->habitRepository->getVersion($accountLogicalId);

        if ($updatedAt === null) {
            return self::EMPTY_DATABASE_VERSION_VALUE;
        }

        return $updatedAt->format(DateTimeImmutable::ATOM);
    }
}
