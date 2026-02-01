<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Create;

use Override;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Factory\DaemonToken\DaemonTokenFactoryInterface;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;

final readonly class DaemonTokenCreateService implements DaemonTokenCreateServiceInterface
{
    public function __construct(
        private DaemonTokenFactoryInterface $daemonTokenFactory,
        private DaemonTokenRepositoryInterface $daemonTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $token): DaemonToken
    {
        $entity = $this->daemonTokenFactory->create($token);
        $this->daemonTokenRepository->save($entity);

        return $entity;
    }
}
