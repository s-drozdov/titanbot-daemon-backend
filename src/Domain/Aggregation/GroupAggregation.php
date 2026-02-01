<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Aggregation;

use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

/**
 * @template TGroupField of mixed
 * @template TEntity of EntityInterface
 */
final readonly class GroupAggregation
{
    public function __construct(

        /** @var TGroupField $group */
        public mixed $group,

        /** @var ListInterface<TEntity> $entityList */
        public ListInterface $entityList,
    ) {
        /*_*/
    }
}
