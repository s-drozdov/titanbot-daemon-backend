<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\DaemonTokenMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\DaemonToken\Index\DaemonTokenIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<DaemonTokenIndexQuery,DaemonTokenIndexQueryResult>
 */
final readonly class DaemonTokenIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DaemonTokenIndexServiceInterface $daemonTokenIndexService,

        /** @var DaemonTokenMapper $deviceMapper */
        private DaemonTokenMapper $daemonTokenMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DaemonTokenIndexQueryResult
    {
        $paginationResult = $this->daemonTokenIndexService->perform($query->token);

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, DaemonToken $entity) {
                $result[(string) $entity->getUuid()] = $this->daemonTokenMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new DaemonTokenIndexQueryResult(
            uuid_to_token_map: new Map(
                value: $mapValue,
                innerType: $this->daemonTokenMapper->getDtoType(),
            ),
        );
    }
}
