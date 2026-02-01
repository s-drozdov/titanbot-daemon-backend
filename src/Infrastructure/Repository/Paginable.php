<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Doctrine\ORM\QueryBuilder;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Domain\Repository\Filter\FilterInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @template T of EntityInterface
 */
trait Paginable
{
    /**
     * https://github.com/vimeo/psalm/issues/8563
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * 
     * @param class-string<T> $entityClass
     * 
     * @return PaginationResult<T>
     */
    private function paginate(QueryBuilder $queryBuilder, FilterInterface $filter, string $entityClass, string $alias): PaginationResult
    {
        $total = $filter->getPager()?->getTotal() ?? (clone $queryBuilder)
            ->select(sprintf('COUNT(%s.uuid)', $alias))
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $pager = $filter->getPager();

        if ($pager !== null) {
            $queryBuilder
                ->setFirstResult($pager->getOffset())
                ->setMaxResults($pager->getLimit())
            ;
        }

        /** @var array<int, T> $entityList */
        $entityList = $queryBuilder
            ->getQuery()
            ->getResult()
        ;

        return new PaginationResult(
            items: new Collection($entityList, $entityClass),
            total: (int) $total,
        );
    }
}
