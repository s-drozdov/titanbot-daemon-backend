<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonDb\Checksum\DaemonDbChecksumGetServiceInterface;

/**
 * @implements QueryHandlerInterface<DaemonDbChecksumGetQuery,DaemonDbChecksumGetQueryResult>
 */
final readonly class DaemonDbChecksumGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DaemonDbChecksumGetServiceInterface $daemonDbChecksumGetService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DaemonDbChecksumGetQueryResult
    {
        return new DaemonDbChecksumGetQueryResult(
            checksum: $this->daemonDbChecksumGetService->perform($query->logical_id),
        );
    }
}
