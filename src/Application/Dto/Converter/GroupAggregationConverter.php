<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Converter;

use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Aggregation\GroupAggregation;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;
use Titanbot\Daemon\Application\Dto\Aggregation\DtoGroupAggregation;

/**
 * @template TEntity of EntityInterface
 * @template TDto of DtoInterface
 * @template TGroupField of mixed
 */
final readonly class GroupAggregationConverter
{
    /**
     * @param ListInterface<GroupAggregation<TGroupField,TEntity>> $aggregationList
     * @param MapperInterface<TEntity, TDto> $mapper
     * 
     * @return ListInterface<DtoGroupAggregation<TGroupField,TDto>>
     */
    public function convert(ListInterface $aggregationList, MapperInterface $mapper): ListInterface
    {
        return new Collection(
            array_map(
                fn (GroupAggregation $aggregation) => $this->getDtoAggregation($aggregation, $mapper),
                $aggregationList->toArray(),
            ),
            DtoGroupAggregation::class,
        );
    }

    /**
     * @param GroupAggregation<TGroupField,TEntity> $aggregation
     * @param MapperInterface<TEntity, TDto> $mapper
     * 
     * @return DtoGroupAggregation<TGroupField,TDto>
     */
    private function getDtoAggregation(GroupAggregation $aggregation, MapperInterface $mapper): DtoGroupAggregation
    {
        return new DtoGroupAggregation(
            group: $aggregation->group,
            items: new Collection(
                array_map(

                    /** 
                     * @param TEntity $entity 
                     * 
                     * @return TDto
                     */
                    fn (EntityInterface $entity) => $mapper->mapDomainObjectToDto($entity),
                    
                    $aggregation->entityList->toArray(),
                ),
                $mapper->getDtoType(),
            ),
        );
    }
}
