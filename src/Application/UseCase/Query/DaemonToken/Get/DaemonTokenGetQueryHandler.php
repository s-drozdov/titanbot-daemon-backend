<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Get;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\DaemonTokenMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonToken\Get\DaemonTokenGetServiceInterface;

/**
 * @implements QueryHandlerInterface<DaemonTokenGetQuery,DaemonTokenGetQueryResult>
 */
final readonly class DaemonTokenGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DaemonTokenGetServiceInterface $daemonTokenGetService,

        /** @var DaemonTokenMapper $daemonTokenMapper */
        private DaemonTokenMapper $daemonTokenMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DaemonTokenGetQueryResult
    {
        return new DaemonTokenGetQueryResult(
            daemon_token: $this->daemonTokenMapper->mapDomainObjectToDto(
                $this->daemonTokenGetService->perform($query->uuid),
            ),
        );
    }
}
