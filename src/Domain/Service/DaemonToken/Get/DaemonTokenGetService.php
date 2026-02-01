<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Get;

use Override;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class DaemonTokenGetService implements DaemonTokenGetServiceInterface
{
    public function __construct(
        private DaemonTokenRepositoryInterface $daemonTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): DaemonToken
    {
        return $this->daemonTokenRepository->getByUuid($uuid);
    }
}
