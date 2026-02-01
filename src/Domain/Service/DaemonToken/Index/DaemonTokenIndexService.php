<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\Index;

use Override;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Repository\Filter\DaemonTokenFilter;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;

final readonly class DaemonTokenIndexService implements DaemonTokenIndexServiceInterface
{
    public function __construct(
        private DaemonTokenRepositoryInterface $daemonTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(?string $token = null): PaginationResult
    {
        return $this->daemonTokenRepository->findByFilter(
            new DaemonTokenFilter(token: $token),
        );
    }
}
