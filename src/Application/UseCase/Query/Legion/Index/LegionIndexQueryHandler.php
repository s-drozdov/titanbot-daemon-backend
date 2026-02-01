<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Legion\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\LegionMapper;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Legion\Index\LegionIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<LegionIndexQuery,LegionIndexQueryResult>
 */
final readonly class LegionIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LegionIndexServiceInterface $legionIndexService,

        /** @var LegionMapper $legionMapper */
        private LegionMapper $legionMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): LegionIndexQueryResult
    {
        $paginationResult = $this->legionIndexService->perform($query->title, $query->pay_day_of_month);

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, Legion $entity) {
                $result[(string) $entity->getUuid()] = $this->legionMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new LegionIndexQueryResult(
            uuid_to_legion_map: new Map(
                value: $mapValue,
                innerType: $this->legionMapper->getDtoType(),
            ),
        );
    }
}
