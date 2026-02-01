<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\EmpireDateMapper;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\EmpireDate\Index\EmpireDateIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<EmpireDateIndexQuery,EmpireDateIndexQueryResult>
 */
final readonly class EmpireDateIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmpireDateIndexServiceInterface $empireDateIndexService,

        /** @var EmpireDateMapper $empireDateMapper */
        private EmpireDateMapper $empireDateMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): EmpireDateIndexQueryResult
    {
        $paginationResult = $this->empireDateIndexService->perform($query->date);

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, EmpireDate $entity) {
                $result[(string) $entity->getUuid()] = $this->empireDateMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new EmpireDateIndexQueryResult(
            uuid_to_empire_date_map: new Map(
                value: $mapValue,
                innerType: $this->empireDateMapper->getDtoType(),
            ),
        );
    }
}
