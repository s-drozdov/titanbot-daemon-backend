<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonDb\Get\DaemonDbGetServiceInterface;

/**
 * @implements QueryHandlerInterface<DaemonDbGetQuery,DaemonDbGetQueryResult>
 */
final readonly class DaemonDbGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DaemonDbGetServiceInterface $daemonDbGetServiceInterface,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DaemonDbGetQueryResult
    {
        return new DaemonDbGetQueryResult(
            temp_file: $this->daemonDbGetServiceInterface->perform($query->logical_id),
        );
    }
}
