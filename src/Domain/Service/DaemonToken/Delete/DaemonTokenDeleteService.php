<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Delete;

use Override;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;

final readonly class DaemonTokenDeleteService implements DaemonTokenDeleteServiceInterface
{
    public function __construct(
        private DaemonTokenRepositoryInterface $daemonTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(UuidInterface $uuid): DaemonToken
    {
        $entity = $this->daemonTokenRepository->getByUuid($uuid);
        $this->daemonTokenRepository->delete($entity);

        return $entity;
    }
}
