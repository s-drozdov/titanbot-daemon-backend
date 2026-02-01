<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository\Aggregation;

use Doctrine\ORM\QueryBuilder;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Aggregation\GroupAggregation;

/** 
 * @template T of EntityInterface
 */
interface GroupAggregationProcessorInterface
{
    /**
     * @param class-string<T> $entityClass
     * 
     * @return ListInterface<GroupAggregation<mixed,T>>
     */
    public function process(QueryBuilder $qb, string $groupPropertyExpression, string $entityClass): ListInterface;
}
