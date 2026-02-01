<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\DaemonToken\DeleteByValue;

use Override;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;
use Titanbot\Daemon\Domain\Repository\Filter\DaemonTokenFilter;
use Webmozart\Assert\Assert;

final readonly class DaemonTokenByValueDeleteService implements DaemonTokenByValueDeleteServiceInterface
{
    public function __construct(
        private DaemonTokenRepositoryInterface $daemonTokenRepository,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(string $token): DaemonToken
    {
        $paginationResult = $this->daemonTokenRepository->findByFilter(
            new DaemonTokenFilter(
                token: $token,
            ),
        );

        $entityList = $paginationResult->items->toArray();

        Assert::notEmpty($entityList);

        /** @var DaemonToken $entity */
        $entity = current($entityList);

        $this->daemonTokenRepository->delete($entity);

        return $entity;
    }
}
